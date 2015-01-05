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

    }
}
