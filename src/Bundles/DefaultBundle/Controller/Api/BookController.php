<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 20.07.15
 * Time: 0:10
 */

namespace Bundles\DefaultBundle\Controller\Api;


use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookController extends Controller
{

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
        $res = json_decode($serializer->serialize($bookInfoResponse->getEntity(), 'json'),true);

        return new JsonResponse($res);
    }

}