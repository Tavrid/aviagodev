<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 21.12.14
 * Time: 15:07
 */

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Symfony\Component\HttpFoundation\Request;


class OrderController extends Controller
{

    /**
     * @param Request $request
     * @param $orderID
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function orderAction(Request $request, $orderID)
    {

        $orderManager = $this->get('admin.order.manager');
        $order = $orderManager->getOrderByOrderId($orderID);
        $form = $this->createForm('pay_form');
        $bookInfoResponse = new BookInfoResponse();
        $bookInfoResponse->setResponseData($order->getOrderInfo());

        return $this->render('BundlesDefaultBundle:Order:order.html.twig', [
            'order' => $order,
            'bookInfo' => $bookInfoResponse->getEntity(),
            'payForm' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param $orderID
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createPayAction(Request $request, $orderID)
    {
        $orderManager = $this->get('admin.order.manager');
        $order = $orderManager->getOrderByOrderId($orderID);
        if (!$order) {
            throw $this->createNotFoundException();
        }
        $form = $this->createForm('pay_form');
        $form->submit($request);
        if ($form->isValid()) {
            $pay = $this->get('bundels_default.payu.manager');
            $pay_form = $pay
                ->setOrderId($order->getOrderId())
                ->setPayMethod($form->get('pay_method')->getData())
                ->addName('Book')
                ->addCode($order->getPnr())
                ->addInfo('some_info1')
                ->createForm();
            return $this->render('BundlesDefaultBundle:Pay:pay.html.twig', [
                'pay_form' => $pay_form
            ]);
        }
        throw $this->createNotFoundException();
    }
} 