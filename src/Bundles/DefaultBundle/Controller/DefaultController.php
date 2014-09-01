<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Bundles\ApiBundle\Api\Query\AviaCityByQuery;

class DefaultController extends Controller
{
    // C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440
    public function indexAction()
    {
        /** @var \Bundles\ApiBundle\Api\Api $api */
//        $api = $this->get('avia.api.manager');
//        $query = new AviaCityByQuery();
//        $query->setQuery('Гон');
//        $output = $api->getCityRequestor()->execute($query);
//
        return $this->render('BundlesDefaultBundle:Default:index.html.twig');
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
