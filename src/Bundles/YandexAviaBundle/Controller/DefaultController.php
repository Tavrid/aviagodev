<?php

namespace Bundles\YandexAviaBundle\Controller;

use Bundles\ApiBundle\Api\Query\SearchByQuery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $api = $this->get('avia.api.manager');
        $query = new SearchByQuery();
        $query->setParams([
            'city_from_code' => 'MIL',
            'city_to_code' => 'BJS',
            'date_from' => '2015-06-20',
            'date_to' => '2015-06-27',
            'class' => 'F',
            'adults' => 1,
            'children' => 0,
            'infant' => 0,
            'return_way' => true
        ]);
        $res = $api->getSearchRequestor()->execute($query);

        $res = $this->get('yandex_avia.routes_generator')->generate($res);
        return new Response($res,200,['Content-type'=>'text/xml']);
    }
}
