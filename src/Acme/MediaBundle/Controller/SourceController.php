<?php

namespace Acme\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

//use Acme\DemoBundle\Model\Uploader;

class SourceController extends Controller {

    /**
     * @param $id
     * @param $type
     * @return Response
     */
    public function indexAction($id, $type) {
        $this->get('uploader.service.container')
            ->getService($type)
            ->setAvatar($id);

        return new Response(json_encode(array('success'=>true)));
    }

}
