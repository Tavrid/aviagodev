<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundles\DefaultBundle\Form\SearchForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $form = $this->createForm('search_form', null, ['city_manager' => $this->get('admin.city.manager')]);
        return $this->render('BundlesDefaultBundle:Default:index.html.twig', [
            'form' => $this->get('acme_core.form_serializer')->serializeForm($form)
        ]);
    }



}
