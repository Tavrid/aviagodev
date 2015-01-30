<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 21.12.14
 * Time: 15:07
 */

namespace Bundles\DefaultBundle\Controller;

use Bundles\ApiBundle\Api\Entity\Ticket;
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
            'payForm' => $form->createView(),
            'numPassenger' => $this->getCountTravelers($bookInfoResponse->getEntity()->getTicket())
        ]);
    }

    public function searchPnrAction(Request $request){
        if($request->getMethod() == 'POST'){
            $pnr = trim($request->get('pnr'));
            $order = $this->get('admin.order.manager')->getOrderBuPnr($pnr);
            if(!empty($order)){
                return $this->redirect($this->generateUrl('bundles_default_api_order',array("orderID" => $order->getOrderId())));
            }
        }
        return $this->render('BundlesDefaultBundle:Order:search.html.twig');
    }

    /**
     * @param Ticket $ticket
     * @return int
     */
    private function getCountTravelers(Ticket $ticket){
        $numPassenger = 0 ;
        foreach($ticket->getTravelers() as $traveler){
            $numPassenger+=count($traveler);
        }
        return $numPassenger;
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
                ->addInfo(htmlspecialchars('[{"departuredate":"20130716","locationnumber":2,"locationcode1":"SVX","locationcode2":"MSQ","passengername":"TATIANA PONOMAREVA","reservationcode":"VJRVNU"}]'))
                ->setDate($order->getDate())
                ->addPrice($order->getPrice())
                ->createForm();
            return $this->render('BundlesDefaultBundle:Pay:pay.html.twig', [
                'pay_form' => $pay_form
            ]);
        }
        throw $this->createNotFoundException();
    }
} 