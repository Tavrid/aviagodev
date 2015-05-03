<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 21.12.14
 * Time: 15:07
 */

namespace Bundles\DefaultBundle\Controller;

use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Query\AviaCheck;
use Bundles\ApiBundle\Api\Util\TicketEntityCreator;
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
        $bookInfoResponse = new BookInfoResponse(new TicketEntityCreator($this->get('avia.api.traslator')));
        $bookInfoResponse->setResponseData($order->getOrderInfo());

        $query = new AviaCheck();
        $query->setParams([
            'pnr' => $order->getPnr(),
            'surname' => $bookInfoResponse->getEntity()->getTicket()->getSurnames()[0]
        ]);

        $response = $this->get('avia.api.manager')->getAviaCheckRequestor()->execute($query);

        return $this->render('BundlesDefaultBundle:Order:order.html.twig', [
            'order' => $order,
            'bookInfo' => $bookInfoResponse->getEntity(),
            'payForm' => $form->createView(),
            'numPassenger' => $this->getCountTravelers($bookInfoResponse->getEntity()->getTicket()),
            'status' => $response->getEntity()
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

} 