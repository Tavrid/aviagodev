<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 28.02.15
 * Time: 12:13
 */

namespace Bundles\DefaultBundle\Controller;

use Acme\AdminBundle\Entity\Order;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Bundles\ApiBundle\Api\Util\TicketEntityCreator;
use Bundles\DefaultBundle\Form\PayForm;
use Bundles\DefaultBundle\Util\NumToStr;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;


class PayController extends Controller{


    /**
     * @param Request $request
     * @param $orderID
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createPayAction(Request $request, $orderID)
    {
        $order = $this->findOrder($orderID);
        $form = $this->createForm('pay_form');
        $form->submit($request);
        if ($form->isValid()) {

            if($form->get('pay_method')->getData() == 'VISA_PRIVAT'){
                return $this->render('BundlesDefaultBundle:Pay:privat.html.twig',[
                    'form' => $this->get('bundles_default.liqupay_api')->createForm($order)
                ]);
            } else if($form->get('pay_method')->getData() == 'GENERATE_CHECK'){

                return $this->renderAndGenerateCheck($order,$form);
            }

        }
        throw $this->createNotFoundException();
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

    private function renderAndGenerateCheck(Order $order,Form $form){
        $bookInfoResponse = new BookInfoResponse(new TicketEntityCreator());
        $bookInfoResponse->setResponseData($order->getOrderInfo());
        $numToStr = new NumToStr();
        return $this->render('BundlesDefaultBundle:Pay:check.html.twig',[
            'order' => $order,
            'entity' => $bookInfoResponse->getEntity(),
            'numToStr' => $numToStr,
            'formData' => $form->getData()

        ]);
    }

//TODO PAYU api
//            $pay = $this->get('bundels_default.payu.manager');
//            $pay_form = $pay
//                ->setOrderId($order->getOrderId())
//                ->setPayMethod($form->get('pay_method')->getData())
//                ->addName('Book')
//                ->addCode($order->getPnr())
//                ->addInfo(htmlspecialchars('[{"departuredate":"20130716","locationnumber":2,"locationcode1":"SVX","locationcode2":"MSQ","passengername":"TATIANA PONOMAREVA","reservationcode":"VJRVNU"}]'))
//                ->setDate($order->getDate())
//                ->addPrice($order->getPrice())
//                ->createForm();
//            return $this->render('BundlesDefaultBundle:Pay:pay.html.twig', [
//                'pay_form' => $pay_form
//            ]);

}