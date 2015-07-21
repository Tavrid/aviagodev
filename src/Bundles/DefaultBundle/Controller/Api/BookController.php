<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 20.07.15
 * Time: 0:10
 */

namespace Bundles\DefaultBundle\Controller\Api;


use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use FOS\RestBundle\Controller\FOSRestController;
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
        $form = $this->createForm('order', null, ['bookInfoResponse' => $bookInfoResponse]);
        $form->handleRequest($request);

        return new JsonResponse(
            [
                'is_valid' => $form->isValid(),
                'form' => $this->get('acme_core.form_serializer')->serializeForm($form)
            ]
        );
    }

}