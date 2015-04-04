<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageGeneratorController extends Controller
{
    public function indexAction(Request $request,$uri)
    {
        header('Content-Type: text/html; charset=utf-8');
        $data = $this->get('seo.model.manager')->parseUri($uri);
        if(!$data){
            throw $this->createNotFoundException('Error parse uri');
        }

        $twig = clone $this->get('twig');
        $twig->setLoader(new \Twig_Loader_String());
        $rendered = $twig->render(
            $data->getTemplate(),
            array("data" => $data)
        );
        $metaTags = [
            'title' => '',
            'keywords' => '',
            'description' => ''
        ];
        if(is_array($data->getMetaTags())){
            foreach ($data->getMetaTags() as $k => $v){
                $metaTags[$k] = $twig->render(
                    $v,
                    array("data" => $data)
                );
            }
        }

        $h1 = $twig->render(
            $data->getH1(),
            array("data" => $data)
        );

        return $this->render('BundlesDefaultBundle:PageGenerator:show.html.twig',[
            'data' => $data,
            'form_data' => [],
            'form' => $form = $this->createForm('search_form')->createView(),
            'content' => $rendered,
            'h1' => $h1,
            'metaTags' => $metaTags
        ]);
    }
}