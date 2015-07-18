<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 19.07.15
 * Time: 0:35
 */

namespace Bundles\DefaultBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FlightController extends Controller
{

    public function listAction(Request $request)
    {

        $resp = $this->render('BundlesDefaultBundle:AngularViews:flight.html.twig', array(
            'params' => $request->get('_route_params'),
            'searchFormOptions' => $this->get('bundles_default.search_form.options')->getFormOptions()

        ));

        return $resp;
    }

}