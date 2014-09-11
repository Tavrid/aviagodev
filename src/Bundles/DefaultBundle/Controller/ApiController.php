<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Bundles\DefaultBundle\Form\SearchForm;

use Bundles\ApiBundle\Api\Query\AviaCityByQuery;
use Bundles\ApiBundle\Api\Query\SearchByQuery;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Bundles\DefaultBundle\Response\AjaxSearchResponse;

class ApiController extends Controller
{
    // C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440
    public function searchCityAction(Request $request)
    {
        $q = $request->get('q');
        /** @var \Bundles\ApiBundle\Api\Api $api */
        $api = $this->get('avia.api.manager');
        $query = new AviaCityByQuery();
        $query->setQuery($q);
        $output = $api->getCityRequestor()->execute($query);
        $resp = $output->getResponseData();
        $resp= new Response(json_encode($resp['result']));
        $resp->headers->add(array('Content-Type' => 'application/json'));
        return $resp;

    }

    public function listAction(Request $request){

        $form = $this->createForm(new SearchForm());
        $data = $request->get('_route_params');
        $data['best_price'] = boolval($data['best_price']);
        $data['direct_flights'] = boolval($data['direct_flights']);
        $form->submit($data);

        if($form->isValid()){
            /** @var \Bundles\ApiBundle\Api\Api $api */
            $api = $this->get('avia.api.manager');
            $params = $form->getData();
            $query = new SearchByQuery();
            $query->setParams($params);
            $output = $api->getSearchRequestor()->execute($query);


            if(!$output->getIsError()){

                $resp = $this->render('BundlesDefaultBundle:Api:list.html.twig',array('data' => $output,'form' => $form->createView()));

//                $resp= new Response($data);
//                $resp->headers->add(array('Content-Type' => 'application/json'));
            } else {
                $resp = new Response('',Response::HTTP_BAD_REQUEST);
            }
        } else {
            $resp = new Response('',Response::HTTP_BAD_REQUEST);
        }
        return $resp;
    }

    public function searchAction(Request $request){
        $form = $this->createForm(new SearchForm());
        $form->submit($request);

        if($form->isValid()){
            /** @var \Bundles\ApiBundle\Api\Api $api */
            $api = $this->get('avia.api.manager');
            $params = $form->getData();

            $query = new SearchByQuery();
            $query->setParams($params);
            $output = $api->getSearchRequestor()->execute($query);

            if(!$output->getIsError()){
                $params = $form->getData();
                $params['best_price'] = intval($params['best_price']);
                $params['direct_flights'] = intval($params['direct_flights']);
//                foreach ($params as $key => $val){
//                    if(empty($val)){
//                        unset($params[$key]);
//                    }
//                }
                $resp= new AjaxSearchResponse($this->generateUrl('bundles_default_api_list',$params));
            } else {
                $resp = new Response('',Response::HTTP_BAD_REQUEST);
            }
        } else {
            $resp = new Response('',Response::HTTP_BAD_REQUEST);
        }
        return $resp;
    }

}
