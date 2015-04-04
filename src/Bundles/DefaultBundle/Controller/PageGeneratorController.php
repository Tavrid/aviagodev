<?php

namespace Bundles\DefaultBundle\Controller;

use Acme\AdminBundle\Entity\Seo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageGeneratorController extends Controller
{
    public function indexAction(Request $request, $uri)
    {
        header('Content-Type: text/html; charset=utf-8');
        $data = $this->get('seo.model.manager')->parseUri($uri);
        if (!$data) {
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
        if (is_array($data->getMetaTags())) {
            foreach ($data->getMetaTags() as $k => $v) {
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
        $formData = $this->buildFormData($request,$data);

        return $this->render('BundlesDefaultBundle:PageGenerator:show.html.twig', [
            'data' => $data,
            'form_data' => $formData,
            'form' => $form = $this->createForm('search_form')->createView(),
            'content' => $rendered,
            'h1' => $h1,
            'metaTags' => $metaTags
        ]);
    }

    protected function buildFormData(Request $request, Seo $seo)
    {
        $formData = [
            'city_from_code' => $seo->getCityFrom()->getCityCodeEng(),
            'city_from' => $seo->getCityFrom()->getFormattedNameCity($request->getLocale()),
            'city_to_code' => $seo->getCityTo()->getCityCodeEng(),
            'city_to' => $seo->getCityTo()->getFormattedNameCity($request->getLocale()),
            'date_from' => date('Y-m-d',mktime(0,0,0,date('m'),date('d')+7,date('Y'))),
            'date_to' => date('Y-m-d',mktime(0,0,0,date('m'),date('d')+14,date('Y'))),
            'return_way' => 1
        ];

        return $formData;
    }
}