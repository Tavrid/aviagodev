<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Bundles\ApiBundle\Api\Query\AviaCityByQuery;

class DefaultController extends Controller
{
    // C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440
    public function indexAction()
    {

        $entities = $this->get('admin.slider.manager')->getSliders();
        $query = new AviaCityByQuery();
        $query->setQuery('Гон');
        $output = $this->get('avia.api.manager')->execute($query);
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
