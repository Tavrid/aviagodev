<?php

namespace Bundles\DefaultBundle\Controller;

use Bundles\ApiBundle\Api\Api;
use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Query\AviaFareRulesQuery;
use Bundles\ApiBundle\Api\Util\TicketEntityCreator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundles\DefaultBundle\Form\BookInfoForm;
use Bundles\DefaultBundle\Form\OrderForm;
use Bundles\ApiBundle\Api\Query\SearchByQuery;
use Bundles\ApiBundle\Api\Query\BookInfoQuery;
use Bundles\ApiBundle\Api\Query\BookQuery;
use Bundles\ApiBundle\Api\Query\AviaCalendarQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Bundles\DefaultBundle\Response\AjaxSearchResponse;
use Bundles\ApiBundle\Api\Model\SearchResultFilter;
use Bundles\ApiBundle\Api\Model\SearchFilters;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Symfony\Component\Form\FormError;
use Bundles\ApiBundle\Api\Util\Calendar;
use Bundles\DefaultBundle\Model\PayU;

class ApiController extends Controller
{

    // C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440
    public function searchCityAction(Request $request)
    {
        $q = $request->get('q');
        /** @var \Bundles\ApiBundle\Api\Api $api */
//        $api = $this->get('avia.api.manager');
//        $query = new AviaCityByQuery();
//        $query->setQuery($q);
//        $output = $api->getCityRequestor()->execute($query);
//        $resp = $output->getResponseData();
        $model = $this->get('admin.city.manager');
        $resp = new Response(json_encode($model->searchByToken($q)));
        $resp->headers->add(array('Content-Type' => 'application/json'));
        return $resp;
    }

    public function infoAction(Request $request)
    {
        $form = $this->createForm(new BookInfoForm());
        $form->submit($request);
        if ($form->isValid()) {
            /** @var \Bundles\ApiBundle\Api\Api $api */
            $api = $this->get('avia.api.manager');
            $query = new BookInfoQuery();
            $data = $form->getData();
            $query->setParams($data);
            $output = $api->getBookInfoRequestor()->execute($query);
            if (!$output->getIsError()) {
                $str = implode(':', $data['variants']);

                $key = md5($str);
                $memcache = $this->get('main.cache');
                $memcache->set($key, $output->getResponseData(), 3600);
                $resp = new JsonResponse(['url' => $this->generateUrl('bundles_default_api_book', ['key' => $key])]);
                return $resp;
            }
        }
        return new Response('', 404);
    }

    public function bookAction(Request $request, $key)
    {
        $memcache = $this->get('main.cache');
        $bookInfoResponse = new BookInfoResponse($this->get('avia.api.ticket_entity_creator'),new BookInfoQuery());
        $d = $memcache->get($key);
        if (empty($d)) {
            throw $this->createNotFoundException();
        }
        $bookInfoResponse->setResponseData($d);

        $orderManager = $this->get('admin.order.manager');
        $entity = $orderManager->getEntity();

        $form = $this->createForm('order', $entity, [
            'bookInfoResponse' => $bookInfoResponse
        ]);

        if ($request->isMethod('post')) {

            $entity->setPrice($bookInfoResponse->getEntity()->getTicket()->getTotalPrice());
            $form->submit($request);
            if ($form->isValid()) {

                $query = new BookQuery();
                $travelers = $entity->getPassengers();

                $query->setParams([
                    'bookID' => $bookInfoResponse->getEntity()->getBookId(),
                    'travellers' => $travelers,
                    'contacts' => array(
                        'Email' => $entity->getEmail(),
                        'PhoneMobile' => $entity->getPhone(),
                        'PhoneHome' => ''
                    ),
                ]);
                /* @var $api Api */
                $api = $this->get('avia.api.manager');
                $output = $api->getBookRequestor()->execute($query);
                if (!$output->getIsError() && $output->getPnr()) {
                    $d = $output->getResponseData();
                    $entity->setPnr($output->getPnr())
                        ->setOrderInfo($d);
                    $orderManager->save($entity);
                    return $this->redirect($this->generateUrl('bundles_default_api_order', array(
                        'orderID' => $entity->getOrderId()
                    )));
                } else {
                    $form->addError(new FormError($this->get('translator')->trans('frontend.book.error_book')));
                }
            }
        }
        /* @var $countryManager \Acme\AdminBundle\Model\Country */
        $countryManager = $this->get('country.model.manager');
        return $this->render('BundlesDefaultBundle:Api:book.html.twig', [
            'form' => $form->createView(),
            'ticket' => $bookInfoResponse->getEntity()->getTicket(),
            'masks' => json_encode($countryManager->getMasks()),
            'numPassenger' => array_sum($bookInfoResponse->getEntity()->getTicket()->getTravelers()),
            'fareRules' => json_decode($this->getAviaFareRules($bookInfoResponse->getEntity()->getTicket())->getFareRules(),true)
        ]);
    }

    private function getAviaFareRules(Ticket $ticket){
        $query = new AviaFareRulesQuery();
        $params = array(
            'request_id' => $ticket->getRequestId()
        );
        $variants = array();
        foreach($ticket->getItineraries() as $t){
            foreach($t->getVariants() as $variant){
                $variants[] = $variant->getVariantID();
            }
        }
        $params['variants'] = $variants;
        $query->setParams($params);
        return $this->get('avia.api.manager')->getAviaFareRulesRequestor()->execute($query);
    }

    public function addSearchData($params, $data)
    {
        $this->get('bundles_default.util.previous_flight')->addFlight($params);
        $this->get('session')->set('formData', $data);
    }

    public function listAction(Request $request)
    {

        $form = $this->createForm('search_form', null, ['city_manager' => $this->get('admin.city.manager')]);
        $formBook = $this->createForm(new BookInfoForm());
        $data = $request->get('_route_params');

        if (empty($data['best_price'])) {
            unset($data['best_price']);
        }
        if (empty($data['direct_flights'])) {
            unset($data['direct_flights']);
        }

        $form->submit($data);

        $this->addSearchData($request->get('_route_params'), $this->get('bundles_default_util_route')->resolveParams($request->get('_route_params')));

        $resp = $this->render('BundlesDefaultBundle:Api:list.html.twig', array(
            'form' => $form->createView(),
            'form_info' => $formBook->createView(),
            'form_data' => $this->get('bundles_default_util_route')->resolveParams($request->get('_route_params'))

        ));

        return $resp;
    }

    public function getFilteredItemsAction(Request $request, $page)
    {
        $form = $this->createForm('search_form');
        $formBook = $this->createForm(new BookInfoForm());

        $form->submit($request);
        $resp = null;
        /** @var \Bundles\ApiBundle\Api\Api $api */
        $api = $this->get('avia.api.manager');
        $params = $form->getData();

        $query = new SearchByQuery();
        $query->setParams($params);
        $output = $api->getSearchRequestor()->execute($query);
        if (!$output->getIsError()) {
            $filterForm = $this->createForm('filter', null, ['searchResponse' => $output]);
            if ($request->get($filterForm->getName())) {
                $filterForm->submit($request);
                $filterParams = $filterForm->getData();
            } else {
                $filterParams = array();
            }

            $f = new SearchResultFilter($output, $this->container->getParameter('bundles_default.count_on_page'));
            $data = $f->getData($page, SearchFilters::getFiltersByParams($filterForm->getData(), $form->getData()));
            $d = array(
                'html' => $this->renderView('BundlesDefaultBundle:Api:_items.html.twig', array(
                    'data' => $data,
                    'form' => $form->createView(),
                    'form_info' => $formBook->createView(),
                    'numPassenger' => $params['adults'] + $params['infant'] + $params['children']
                )),
                'filter_form' => $this->renderView('BundlesDefaultBundle:Api:_filter_form.html.twig', ['filter_form' => $filterForm->createView()]
                ),
                'countPages' => $f->getCountPages(),
                'hasNext' => $page < $f->getCountPages()
            );
            $resp = new JsonResponse($d);
            return $resp;
        } else {
            throw $this->createNotFoundException();
        }

    }

    public function calendarAction(Request $request)
    {
        $form = $this->createForm('search_form');

        $form->submit($request);
        $resp = null;
        /** @var \Bundles\ApiBundle\Api\Api $api */
        $api = $this->get('avia.api.manager');
        $params = $form->getData();

        $query = new AviaCalendarQuery();
        $query->setParams($params);
        $output = $api->getAviaCalendarRequestor()->execute($query);
        if (!$output->getIsError()) {
            $routeParams = $form->getData();
            //TODO костыль ;)
            $routeParams['direct_flights'] = intval($routeParams['direct_flights']);
            unset($routeParams['city_from'], $routeParams['city_to']);
            return $this->render('BundlesDefaultBundle:Api:_calendar.html.twig', [
                'data' => $output,
                'route_params' => $routeParams,
                'table' => Calendar::createTable($params['date_from'], $params['date_to'])
            ]);
        }
        throw $this->createNotFoundException();
    }

    public function calendarItemInfoAction(Request $request)
    {
        $form = $this->createForm('search_form');
        $form->add('new_date_from', 'text')
            ->add('new_date_to', 'text');

        $queryGet = $request->query->all();

        //TODO костыль ;)
        $queryGet['best_price'] = boolval($queryGet['best_price']);
        $queryGet['direct_flights'] = boolval($queryGet['direct_flights']);

        $form->submit($queryGet);
        if ($form->isValid()) {
            /** @var \Bundles\ApiBundle\Api\Api $api */
            $api = $this->get('avia.api.manager');
            $params = $form->getData();

            $query = new AviaCalendarQuery();
            $query->setParams($params);
            $output = $api->getAviaCalendarRequestor()->execute($query);

            if (!$output->getIsError()) {
                $routeParams = $form->getData();
                //TODO костыль ;)
                $routeParams['best_price'] = intval($routeParams['best_price']);
                $routeParams['direct_flights'] = intval($routeParams['direct_flights']);

                /** @var \Bundles\ApiBundle\Api\Entity\Calendar $calendar */
                $calendar = $output[date('Y-m-d', $routeParams['new_date_from'])];

                $routeParams['date_from'] = date('Y-m-d', $routeParams['new_date_from']);
                if ($calendar->getChild()) {
                    $calendar = $calendar->findChild($routeParams['new_date_to']);
                    $routeParams['date_to'] = date('Y-m-d', $routeParams['new_date_to']);
                }

                unset($routeParams['new_date_to'], $routeParams['new_date_from']);
                return $this->render('BundlesDefaultBundle:Api:_calendar_popup.html.twig', [
                    'ticket' => $calendar->getTicket(),
                    'routeParams' => $routeParams
                ]);

            }
        }
        throw $this->createNotFoundException();
    }

    public function searchAction(Request $request)
    {
        $form = $this->createForm('search_form');
        $form->submit($request);

        if ($form->isValid()) {
            /** @var \Bundles\ApiBundle\Api\Api $api */
            $api = $this->get('avia.api.manager');
            $params = $form->getData();

            $query = new SearchByQuery();
            $query->setParams($params);
            $output = $api->getSearchRequestor()->execute($query);

            if (!$output->getIsError()) {
                $params = $form->getData();
                $params['best_price'] = intval($params['best_price']);
                $params['direct_flights'] = intval($params['direct_flights']);

                $resp = new AjaxSearchResponse($this->generateUrl('bundles_default_api_list', $params));
            } else {
                $resp = new Response('', Response::HTTP_BAD_REQUEST);
            }
        } else {
            $resp = new Response('', Response::HTTP_BAD_REQUEST);
        }
        return $resp;
    }


}
