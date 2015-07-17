<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 13.07.15
 * Time: 22:22
 */

namespace Bundles\DefaultBundle\Controller;

use Bundles\ApiBundle\Api\Model\SearchFilters;
use Bundles\ApiBundle\Api\Model\SearchResultFilter;
use Bundles\ApiBundle\Api\Query\SearchByQuery;

use Bundles\DefaultBundle\Form\BookInfoForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class FilteredItemsController extends Controller
{

    /**
     * @param Request $request
     * @param $page
     * @return null|JsonResponse
     */
    public function getAction(Request $request, $page)
    {
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

            return new Response($data,Response::HTTP_OK,['Content-Type'=>'application/json']);
        } else {
            throw $this->createNotFoundException();
        }

    }
}