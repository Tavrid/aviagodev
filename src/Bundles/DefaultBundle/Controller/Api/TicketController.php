<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 17.07.15
 * Time: 0:43
 */

namespace Bundles\DefaultBundle\Controller\Api;
use Bundles\ApiBundle\Api\Query\BookInfoQuery;
use Bundles\ApiBundle\Api\Query\SearchByQuery;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketController extends Controller
{

    /**
     * @param Request $request
     * @param $page
     * @return null|Response
     */
    public function getTicketsAction(Request $request,$page)
    {
        $resp = null;
        /** @var \Bundles\ApiBundle\Api\Api $api */
        $api = $this->get('avia.api.manager');
        $params = $request->query->all();


        $query = new SearchByQuery();
        $query->setParams($params);

        $output = $api->getSearchRequestor()->execute($query);
        if (!$output->getIsError()) {
            $data = [];
            foreach($output as $key => $val){
                $data[] = $val;
                if($key > 10){
                    break;
                }
            }
            $serializer = $this->get('jms_serializer');
            $data = $serializer->serialize($data, 'json');

            $resp = new Response($data,Response::HTTP_OK,['Content-Type'=>'application/json']);
            return $resp;
        } else {
            throw $this->createNotFoundException();
        }

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function postTicketInfoAction(Request $request)
    {
        $requestId = $request->get('request_id');
        $variants =explode(',',$request->get('variants'));

        $api = $this->get('avia.api.manager');
        $query = new BookInfoQuery();
        $data = ['variants' => $variants,'request_id' => $requestId];
        $query->setParams($data);
        $output = $api->getBookInfoRequestor()->execute($query);
        if (!$output->getIsError()) {
            $str = implode(':', $data['variants']);

            $key = md5($str);
            $memcache = $this->get('main.cache');
            $memcache->set($key, $output->getResponseData(), 3600);
            $resp = new JsonResponse(['url' => $this->generateUrl('bundles_default_api_book', ['key' => $key])]);
            return $resp;
        }

        return new JsonResponse([$requestId,$variants]);
    }

}