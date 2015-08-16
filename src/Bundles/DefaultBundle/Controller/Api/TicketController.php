<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 17.07.15
 * Time: 0:43
 */

namespace Bundles\DefaultBundle\Controller\Api;
use Bundles\ApiBundle\Api\Model\SearchFilters;
use Bundles\ApiBundle\Api\Model\SearchResultFilter;
use Bundles\ApiBundle\Api\Query\BookInfoQuery;
use Bundles\ApiBundle\Api\Query\SearchByQuery;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postFlightUrlAction(Request $request)
    {
        $form = $this->createForm('search_form', null, ['city_manager' => $this->get('admin.city.manager')]);
        $form->handleRequest($request);
        $data = [
            'is_valid' =>$form->isValid(),
            'form' => $this->get('acme_core.form_serializer')->serializeForm($form)
        ];
        if($data['is_valid']){
            $key = $this->get('bundles_default.flight_data')->setData($form->getData());
            $data['url'] = $this->generateUrl('api_list_flight',['key' => $key]);
        } else {
            $data['form_errors'] = $this->get('acme_core.form_serializer')->serializeFormError($form);
        }
        return new JsonResponse($data);
    }

    /**
     * @param Request $request
     * @param $page
     * @return null|JsonResponse
     */
    public function getTicketsAction(Request $request,$page=1)
    {

        $params = $this->get('bundles_default.flight_data')->getData($request->get('key'));
        if(empty($params)){
            throw $this->createNotFoundException();
        }

        $form = $this->createForm('search_form', null, [
            'city_manager' => $this->get('admin.city.manager')
        ]);
        $form->submit($params);
        $data = [
            'form' => $this->get('acme_core.form_serializer')->serializeForm($form)
        ];

        $resp = null;
        $api = $this->get('avia.api.manager');


        $query = new SearchByQuery();
        $query->setParams($form->getData());

        $output = $api->getSearchRequestor()->execute($query);
        if (!$output->getIsError()) {
            $filterForm = $this->createForm('filter', null, ['searchResponse' => $output]);
            $filterForm->submit($request);

            $f = new SearchResultFilter($output, $this->container->getParameter('bundles_default.count_on_page'));
            $outputItems = $f->getData($page, SearchFilters::getFiltersByParams($filterForm->getData(), $params));
            $serializer = $this->get('jms_serializer');
            $data['tickets'] = $serializer->toArray($outputItems);
            $data['filter_form'] = $this->get('acme_core.form_serializer')->serializeForm($filterForm);
            $resp = new JsonResponse($data);
            return $resp;
        } else {
            throw $this->createNotFoundException();
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postTicketInfoAction(Request $request)
    {
        $requestId = $request->get('request_id');
        $variants =explode(',',$request->get('variants'));

        $api = $this->get('avia.api.manager');
        $query = new BookInfoQuery();
        $data = ['variants' => $variants,'request_id' => $requestId];
        $query->setParams($data);
        $output = $api->getBookInfoRequestor()->execute($query);
        if (!$output->getIsError()) {
            $str = implode(':', $data['variants']);

            $key = md5($str);
            $memcache = $this->get('main.cache');
            $memcache->set($key, $output->getResponseData(), 36000);
            $resp = new JsonResponse(['url' => $this->generateUrl('bundles_default_api_book', ['key' => $key])]);
            return $resp;
        }

        return new JsonResponse([$requestId,$variants]);
    }


}