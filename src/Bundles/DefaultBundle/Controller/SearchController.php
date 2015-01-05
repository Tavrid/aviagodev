<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function complexSearchAction(){

    }
}
