<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Bundles\DefaultBundle\Form\SearchForm;

use Bundles\ApiBundle\Api\Query\AviaCityByQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    // C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440
    public function searchCityAction(Request $request)
    {
        $q = $request->get('q');
        /** @var \Bundles\ApiBundle\Api\Api $api */
        $api = $this->get('avia.api.manager');
        $query = new AviaCityByQuery();
        $query->setQuery($q);
        $output = $api->getCityRequestor()->execute($query);
        $resp= new Response(json_encode($output->getResponseData()->result));
        $resp->headers->add(array('Content-Type' => 'application/json'));
        return $resp;

    }

}
