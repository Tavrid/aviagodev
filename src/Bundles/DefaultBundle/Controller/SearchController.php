<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function complexSearchAction(Request $request){
        $par = $this->get('bundles_default_util_route')->resolveParams($request->get('_route_params'));

        $this->addSearchData($request->get('_route_params'),$par);
        var_dump($request->get('_route_params')); exit;
    }

    public function addSearchData($routeParams,$data)
    {
        $flights = $this->get('session')->get('flights', array());
        $d = array(
            'url' => $this->generateUrl('bundles_default_search_complex_search', $routeParams)
        );
        $flights[$this->generateUrl('bundles_default_search_complex_search', $routeParams)] = $d;
        $this->get('session')->set('flights', $flights);
        $this->get('session')->set('formData', $data);
    }
}
