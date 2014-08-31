<?php

namespace Acme\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;



class ImageController extends Controller {

    /**
     * @param Request $request
     * @param $name
     * @param $type
     * @return Response
     */
    public function indexAction(Request $request, $name, $type) {
        $uploader = $this->get('uploader.service.container')->getService($type);
        $code = $request->get('code');
        $filename = $uploader->readFile($code);
        header("Content-type:".$uploader->getEntity()->getMimeType());
        return new Response(readfile($filename));
    }

}
