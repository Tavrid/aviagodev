<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Bundles\DefaultBundle\Form\SearchForm;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    // C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440
    public function indexAction(Request $request)
    {

        $form = $this->createForm(new SearchForm());

        return $this->render('BundlesDefaultBundle:Default:index.html.twig',['form' => $form->createView()]);
    }

}
