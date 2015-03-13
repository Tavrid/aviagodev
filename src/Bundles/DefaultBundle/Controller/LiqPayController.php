<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 13.03.15
 * Time: 20:12
 */

namespace Bundles\DefaultBundle\Controller;
use Acme\AdminBundle\Entity\Order;
use Bundles\DefaultBundle\Model\LiqPayApi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LiqPayController extends Controller{



    public function liqpaySuccessAction(Request $request, $orderID){
        $order = $this->findOrder($orderID);
        $state = $this->get('bundles_default.liqupay_api')->checkStatus($order);

        return $this->render('BundlesDefaultBundle:LiqPay:state.html.twig',array(
            'successPay' => $state == LiqPayApi::SUCCESS_PAY,
            'status' => $state,
            'statuses' => $this->get('bundles_default.liqupay_api')->getStatuses(),
            'order' => $order
        ));
    }

    /**
     * @param $orderID
     * @return Order
     */
    private function findOrder($orderID){
        $orderManager = $this->get('admin.order.manager');
        $order = $orderManager->getOrderByOrderId($orderID);
        if (!$order) {
            throw $this->createNotFoundException();
        }
        return $order;
    }

}