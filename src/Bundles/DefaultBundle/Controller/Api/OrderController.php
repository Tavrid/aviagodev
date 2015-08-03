<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 20.07.15
 * Time: 0:10
 */

namespace Bundles\DefaultBundle\Controller\Api;


use Bundles\ApiBundle\Api\Query\AviaCheck;
use Bundles\ApiBundle\Api\Query\BookQuery;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends FOSRestController
{
    /**
     * @param $key
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getDataAction(Request $request,$orderId)
    {
        $orderManager = $this->get('admin.order.manager');
        $order = $orderManager->getOrderByOrderId($orderId);

        $query = new AviaCheck();
        $query->setParams([
            'pnr' => $order->getPnr(),
            'surname' => $order->getPassengers()['ADT'][0]['Surname']
        ]);
        $response = $this->get('avia.api.manager')->getAviaCheckRequestor()->execute($query);
        $serializer = $this->get('jms_serializer');
        return new JsonResponse([
            'book_info' => $serializer->toArray($response->getEntity())
        ]);
//        return $this->render('BundlesDefaultBundle:Order:order.html.twig', [
//            'order' => $order,
//            'bookInfo' => $bookInfoResponse->getEntity(),
//            'payForm' => $form->createView(),
//            'numPassenger' => $this->getCountTravelers($bookInfoResponse->getEntity()->getTicket()),
//            'status' => $response->getEntity()
//        ]);
    }


}