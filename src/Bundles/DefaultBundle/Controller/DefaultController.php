<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundles\DefaultBundle\Form\SearchForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    // C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440
    public function indexAction(Request $request) {


        $form = $this->createForm('search_form');

        $flights = $this->get('bundles_default.util.previous_flight')->getFlights();
        return $this->render('BundlesDefaultBundle:Default:index.html.twig', [
                    'flights' => $flights,
                    'form' => $form->createView(),
                    'form_data' => $this->get('session')->get('formData',[])
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function changeLocaleAction(Request $request) {
        return new Response();
    }

    public function testAction(){
        return $this->render('BundlesDefaultBundle:Default:test.html.twig');
    }

}
