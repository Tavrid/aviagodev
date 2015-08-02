<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 02.08.15
 * Time: 13:29
 */

namespace Bundles\DefaultBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontendController extends Controller
{
    /**
     * SPA single view
     */
    public function defaultAction()
    {
        $resp = $this->render('BundlesDefaultBundle:Frontend:index.html.twig');
        return $resp;
    }

}