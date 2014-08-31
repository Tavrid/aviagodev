<?php

namespace Acme\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

//use Acme\DemoBundle\Model\Uploader;

class UploadController extends Controller {
    /**
     * @param Request $request
     * @param $type
     * @param null $id
     * @return Response
     */
    public function indexAction(Request $request, $type, $id = NULL) {
        $uploader = $this->get('uploader.service.container')
            ->getService($type);

        if ($request->getMethod() == 'POST') {
            $uploader->upload($request->files->get('files'),$id);
            return $this->render('AcmeMediaBundle:Upload:thumbs.html.twig', array('uploader' => $uploader, 'type' => $type));
        }
        $uploaders = $uploader->getFiles($id);

        return $this->render('AcmeMediaBundle:Upload:index.html.twig', array('id' => $id, 'uploaders' => $uploaders, 'type' => $type));
    }

    /**
     * @param Request $request
     * @param $id
     * @param $type
     * @return Response
     */
    public function deleteAction(Request $request, $id, $type) {
        if ($request->isXmlHttpRequest()) {
            $uploader = $this->get('uploader.service.container')
                ->getService($type);
            $uploader->delete($id);
            return new Response(json_encode(array('status' => 'success')));

        }
        return new Response(json_encode(array('status' => 'error')));
    }

}
