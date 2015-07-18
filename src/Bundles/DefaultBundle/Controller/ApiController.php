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
