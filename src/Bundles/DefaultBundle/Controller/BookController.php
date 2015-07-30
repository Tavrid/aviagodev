<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 19.07.15
 * Time: 1:28
 */

namespace Bundles\DefaultBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{

    public function bookAction(Request $request, $key)
    {
        return $this->render('BundlesDefaultBundle:AngularViews:flight.html.twig',[
            'searchFormOptions' => $this->get('bundles_default.search_form.options')->getFormOptions()

        ]);
    }


}