<?php

namespace Bundles\DefaultBundle\Controller;

use Bundles\DefaultBundle\Form\BookInfoForm;
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
        $form = $this->createForm('search_form', null, ['city_manager' => $this->get('admin.city.manager')]);
        $formBook = $this->createForm(new BookInfoForm());
        return $this->render('BundlesDefaultBundle:Search:list.html.twig', array(
            'form' => $form->createView(),
            'form_info' => $formBook->createView(),
            'form_data' => $this->get('bundles_default_util_route')->resolveParams($request->get('_route_params'))

        ));

    }

    public function actionGetFilteredItems(Request $request){

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
