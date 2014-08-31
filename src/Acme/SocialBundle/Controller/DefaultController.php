<?php

namespace Acme\SocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeSocialBundle:Default:index.html.twig', array('name' => $name));
    }
}
