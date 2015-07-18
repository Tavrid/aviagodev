<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 19.07.15
 * Time: 1:28
 */

namespace Bundles\DefaultBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{

    public function bookAction(Request $request, $key)
    {

        return $this->render('BundlesDefaultBundle:AngularViews:book.html.twig');
    }

//    public function bookAction(Request $request, $key)
//    {
//        $memcache = $this->get('main.cache');
//        $bookInfoResponse = new BookInfoResponse($this->get('avia.api.ticket_entity_creator'));
//        $d = $memcache->get($key);
//        if (empty($d)) {
//            throw $this->createNotFoundException();
//        }
//        $bookInfoResponse->setResponseData($d);
//
//        $orderManager = $this->get('admin.order.manager');
//        $entity = $orderManager->getEntity();
//
//        $form = $this->createForm('order', $entity, [
//            'bookInfoResponse' => $bookInfoResponse
//        ]);
//
//        if ($request->isMethod('post')) {
//
//            $entity->setPrice($bookInfoResponse->getEntity()->getTicket()->getTotalPrice());
//            $form->submit($request);
//            if ($form->isValid()) {
//
//                $query = new BookQuery();
//                $travelers = $entity->getPassengers();
//
//                $query->setParams([
//                    'bookID' => $bookInfoResponse->getEntity()->getBookId(),
//                    'travellers' => $travelers,
//                    'contacts' => array(
//                        'Email' => $entity->getEmail(),
//                        'PhoneMobile' => $entity->getPhone(),
//                        'PhoneHome' => ''
//                    ),
//                ]);
//                /* @var $api Api */
//                $api = $this->get('avia.api.manager');
//                $output = $api->getBookRequestor()->execute($query);
//                if (!$output->getIsError() && $output->getPnr()) {
//                    $d = $output->getResponseData();
//                    $entity->setPnr($output->getPnr())
//                        ->setOrderInfo($d);
//                    $orderManager->save($entity);
//                    return $this->redirect($this->generateUrl('bundles_default_api_order', array(
//                        'orderID' => $entity->getOrderId()
//                    )));
//                } else {
//                    $form->addError(new FormError($this->get('translator')->trans('frontend.book.error_book')));
//                }
//            }
//        }
//        /* @var $countryManager \Acme\AdminBundle\Model\Country */
//        $countryManager = $this->get('country.model.manager');
//        return $this->render('BundlesDefaultBundle:Api:book.html.twig', [
//            'form' => $form->createView(),
//            'ticket' => $bookInfoResponse->getEntity()->getTicket(),
//            'masks' => json_encode($countryManager->getMasks()),
//            'numPassenger' => array_sum($bookInfoResponse->getEntity()->getTicket()->getTravelers()),
//            'fareRules' => json_decode($this->getAviaFareRules($bookInfoResponse->getEntity()->getTicket())->getFareRules(),true)
//        ]);
//    }

}