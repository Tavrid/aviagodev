<?php

namespace Bundles\DefaultBundle\Controller;

use Bundles\ApiBundle\Api\Util\Calendar;
use Bundles\ApiBundle\Api\Model\SearchFilters;
use Bundles\ApiBundle\Api\Model\SearchResultFilter;
use Bundles\ApiBundle\Api\Query\AviaCalendarQuery;
use Bundles\ApiBundle\Api\Query\AviaComplexCalendarQuery;
use Bundles\ApiBundle\Api\Query\ComplexSearchByQuery;
use Bundles\DefaultBundle\Form\BookInfoForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function calendarAction(Request $request)
    {

        $resp = null;
        /** @var \Bundles\ApiBundle\Api\Api $api */
        $api = $this->get('avia.api.manager');
        $params = $this->get('bundles_default_util_route')
            ->resolveParams($request->get('_route_params'));

        $query = new AviaComplexCalendarQuery();
        $query->setParams($params);
        $output = $api->getAviaCalendarRequestor()->execute($query);
        if (!$output->getIsError()) {
            return $this->render('BundlesDefaultBundle:Api:_calendar.html.twig', [
                'data' => $output,
                'route_params' => $params,
                'table' => Calendar::createTable($params['date_from'], $params['date_to'])
            ]);
        }
        throw $this->createNotFoundException();
    }

    public function complexSearchAction(Request $request){
        $par = $this->get('bundles_default_util_route')->resolveParams($request->get('_route_params'));

        $this->addSearchData($request->get('_route_params'),$par);
        $form = $this->createForm('search_form', null, ['city_manager' => $this->get('admin.city.manager')]);
        $formBook = $this->createForm(new BookInfoForm());
        return $this->render('BundlesDefaultBundle:Search:list.html.twig', array(
            'form' => $form->createView(),
            'form_info' => $formBook->createView(),
            'form_data' => $this->get('bundles_default_util_route')->resolveParams($request->get('_route_params'))

        ));

    }

    public function getFilteredItemsAction(Request $request){
        $page = $request->get('page',1);
        $formBook = $this->createForm(new BookInfoForm());
        $api = $this->get('avia.api.manager');
        $params = $this->get('bundles_default_util_route')
            ->resolveParams($request->get('_route_params'));

        $query = new ComplexSearchByQuery();
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
            $data = $f->getData($page, SearchFilters::getFiltersByParams($filterForm->getData(), $params));
            $d = array(
                'html' => $this->renderView('BundlesDefaultBundle:Api:_items.html.twig', array(
                    'data' => $data,
                    'form_info' => $formBook->createView(),
                    'isComplexSearch' => true
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

    public function addSearchData($routeParams,$data)
    {
        $this->get('bundles_default.util.previous_flight')->addFlight($routeParams,true);
        $this->get('session')->set('formData', $data);
    }
}
