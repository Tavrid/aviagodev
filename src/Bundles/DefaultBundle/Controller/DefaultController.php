<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundles\DefaultBundle\Model\ApiCall;

use Bundles\DefaultBundle\Api\AviaCityByQuery;

class DefaultController extends Controller
{
    // C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440
    public function indexAction()
    {

        $entities = $this->get('admin.slider.manager')->getSliders();
        $query = new AviaCityByQuery('C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440');
        
        $output = $this->get('api_caller')->call(
            new ApiCall('http://ws.demo.webservices.aero/',json_encode($query->buildParams(['query' => 'Барс'])))
        );
        echo '<pre>';
        print_r($output);
        exit;
        return $this->render('BundlesDefaultBundle:Default:index.html.twig',array(
            'uploader' => $this->get('admin.slider.uploader'),
            'entities' => $entities
        ));
    }

    public function teamAction()
    {
        return $this->render('BundlesDefaultBundle:Default:team.html.twig');
    }
    public function taskAction()
    {
        return $this->render('BundlesDefaultBundle:Default:task.html.twig');
    }
}
