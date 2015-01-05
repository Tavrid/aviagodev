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
        $par = $request->get('_route_params');
        $complexFields = [];
        $routes = explode('_',$par['city']);
        $date = explode('_',$par['date']);
        foreach($routes as $key => $val){
            $r = explode('-',$val);
            $complexFields[] = [
                'cityFrom' => $this->get('admin.city.manager')->getFormattedNameByIata($r[0]),
                'cityTo' => $this->get('admin.city.manager')->getFormattedNameByIata($r[1]),
                'cityFromCode' => $r[0],
                'cityToCode' => $r[1],
                'date' => $date[$key]
            ];
        }
        $par['complexFields'] = $complexFields;
        unset($par['city']);
        unset($par['date']);
        var_dump($par);
        $this->addSearchData($request->get('_route_params'),$par);
        var_dump($request->get('_route_params')); exit;
    }

    public function addSearchData($routeParams,$data)
    {
        $flights = $this->get('session')->get('flights', array());
        $d = array(
            'url' => $this->generateUrl('bundles_default_search_complex_search', $routeParams),
            'formData' => $data
        );
        $flights[$this->generateUrl('bundles_default_search_complex_search', $routeParams)] = $d;
        $this->get('session')->set('flights', $flights);
    }
}
