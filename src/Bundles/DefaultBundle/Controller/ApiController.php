<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Bundles\DefaultBundle\Form\SearchForm;
use Bundles\DefaultBundle\Form\BookInfoForm;
use Bundles\DefaultBundle\Form\OrderForm;
use Bundles\DefaultBundle\Form\FilterForm;


use Bundles\ApiBundle\Api\Query\AviaCityByQuery;
use Bundles\ApiBundle\Api\Query\SearchByQuery;
use Bundles\ApiBundle\Api\Query\BookInfoQuery;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Bundles\DefaultBundle\Response\AjaxSearchResponse;

use Acme\CoreBundle\Model\ArraySlice;


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

    public function infoAction(Request $request){
        $form = $this->createForm(new BookInfoForm());
        $form->submit($request);
        if($form->isValid()){
            /** @var \Bundles\ApiBundle\Api\Api $api */
            $api = $this->get('avia.api.manager');
            $query = new BookInfoQuery();
            $data  = $form->getData();
            $query->setParams($data);
            $output = $api->getBookInfoRequestor()->execute($query);
            if(!$output->getIsError()){
                $str = implode(':',$data['variants']);

                $key = md5($str);
                /** @var \Memcached $memcache */
                $memcache = $this->get('memcache.default');
                $memcache->set($key,$output,3600);
                $resp= new Response(json_encode(['url' => $this->generateUrl('bundles_default_api_book',['key' => $key])]));
                $resp->headers->add(array('Content-Type' => 'application/json'));
                return $resp;
            }

        }
        return new Response('',Response::HTTP_BAD_REQUEST);
    }

    public function bookAction(Request $request,$key){
        /** @var \Memcached $memcache */
        $memcache = $this->get('memcache.default');
        $data = $memcache->get($key);

        /** @var \Acme\AdminBundle\Model\Order $orderManager */
        $orderManager = $this->get('admin.order.manager');
        $entity = $orderManager->getEntity();

        $form = $this->createForm(new OrderForm($data->getEntity()->getTravelers()),$entity);
        if($request->isMethod('post')){
//            $entity->setPrice($data->getEntity()->getTicket()->getTotalPrice());
            $entity->setPrice($data->getEntity()->getTicket()->getTotalPrice());
            $form->submit($request);
            if($form->isValid()){

                $orderManager->save($entity);
            } else {
//                var_Dump($form->getErrors()); exit;
            }
        }
//        var_dump($data->getEntity()->getTicket()->getItineraries()); exit;
        return $this->render('BundlesDefaultBundle:Api:book.html.twig',[
            'form' => $form->createView(),
            'ticket' => $data->getEntity()->getTicket()
        ]);


    }

    public function listAction(Request $request){

        $form = $this->createForm(new SearchForm());
        $formBook = $this->createForm(new BookInfoForm());
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
                $filterForm = $this->createForm(new FilterForm($output));
                $pa = ArraySlice::slice($output,$this->container->getParameter('bundles_default.count_on_page'),false);

                $resp = $this->render('BundlesDefaultBundle:Api:list.html.twig',array(
                    'data' => isset($pa[0]) ? $pa[0]: array(),
                    'pages' => $pa,
                    'form' => $form->createView(),
                    'form_info' => $formBook->createView(),
                    'filter_form' => $filterForm->createView()
                ));

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
