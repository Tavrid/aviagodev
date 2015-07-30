<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 20.07.15
 * Time: 0:10
 */

namespace Bundles\DefaultBundle\Controller\Api;


use Bundles\ApiBundle\Api\Query\BookQuery;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;

class BookController extends FOSRestController
{
    /**
     * @param $key
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDataAction($key)
    {
        $memcache = $this->get('main.cache');
        $bookInfoResponse = new BookInfoResponse($this->get('avia.api.ticket_entity_creator'));
        $d = $memcache->get($key);
        if (empty($d)) {
            throw $this->createNotFoundException();
        }
        $bookInfoResponse->setResponseData($d);

        $serializer = $this->get('jms_serializer');
        $res = $serializer->toArray($bookInfoResponse->getEntity());
        $form = $this->createForm('order', null, ['bookInfoResponse' => $bookInfoResponse]);
        return new JsonResponse(
            [
                'data' => $res,
                'form' => $this->get('acme_core.form_serializer')->serializeForm($form)
            ]
        );
    }

    /**
     * @param Request $request
     * @param $key
     * @return \Symfony\Component\Form\Form
     */
    public function postCreateAction(Request $request, $key)
    {
        $memcache = $this->get('main.cache');
        $bookInfoResponse = new BookInfoResponse($this->get('avia.api.ticket_entity_creator'));
        $d = $memcache->get($key);
        if (empty($d)) {
            throw $this->createNotFoundException();
        }
        $bookInfoResponse->setResponseData($d);
        $orderManager = $this->get('admin.order.manager');
        $entity = $orderManager->getEntity();
        $form = $this->createForm('order', $entity, ['bookInfoResponse' => $bookInfoResponse]);
        $entity->setPrice($bookInfoResponse->getEntity()->getTicket()->getTotalPrice());
        $form->handleRequest($request);
        if ($form->isValid()) {

            $query = new BookQuery();
            $travelers = $entity->getPassengers();

            $query->setParams([
                'bookID' => $bookInfoResponse->getEntity()->getBookId(),
                'travellers' => $travelers,
                'contacts' => array(
                    'Email' => $entity->getEmail(),
                    'PhoneMobile' => $entity->getPhone(),
                    'PhoneHome' => ''
                ),
            ]);

            $api = $this->get('avia.api.manager');
            $output = $api->getBookRequestor()->execute($query);
            if (!$output->getIsError() && $output->getPnr()) {
                $d = $output->getResponseData();
                $entity->setPnr($output->getPnr())
                    ->setOrderInfo($d);
                $orderManager->save($entity);
                return new JsonResponse([
                    'is_valid' => true,
                    'order_id' => $entity->getOrderId(),
                    'url' => $this->generateUrl('bundles_default_api_order', ['orderID' => $entity->getOrderId()])
                ]);
            } else {
                $form->addError(new FormError($this->get('translator')->trans('frontend.book.error_book')));
            }
        }

        return new JsonResponse(
            [
                'is_valid' => $form->isValid(),
                'form' => $this->get('acme_core.form_serializer')->serializeFormError($form),
                'form_data' => $form->getData()
            ]
        );
    }

}