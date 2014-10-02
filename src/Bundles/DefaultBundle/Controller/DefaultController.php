<?php

namespace Bundles\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Bundles\DefaultBundle\Form\SearchForm;
use Symfony\Component\HttpFoundation\Request;

use Acme\AdminBundle\Entity\City;

class DefaultController extends Controller
{
    // C330CA8C-DCDF-4CA8-A5E0-F5E4E1612440
    public function indexAction(Request $request)
    {
//        ini_set('max_execution_time', 300);
//        $model = $this->get('admin.city.manager');
//        $curl = curl_init();
//            curl_setopt($curl, CURLOPT_URL, 'http://www.apinfo.ru/airports/export.html');
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
//        curl_setopt($curl, CURLOPT_POST, true);
//        curl_setopt($curl, CURLOPT_POSTFIELDS,
//            "fields[]=1&fields[]=3&fields[]=4&fields[]=5&fields[]=6&fields[]=7&fields[]=8&fields[]=9&fields[]=10&fields[]=11&type=xml");
//
//        $out = curl_exec($curl);
//        curl_close($curl);
//        $xml = simplexml_load_string($out);
//
//
//        $em = $this->getDoctrine()->getManager();
//
//        $i = 0 ;
//        foreach($xml as $x){
//            $i++;
//            $city = new City();
//            $city->setIataCode($x->iata_code)
//                ->setNameRus($x->name_rus)
//                ->setNameEng($x->name_eng)
//                ->setCityRus($x->city_rus)
//                ->setCityEng($x->city_eng)
//                ->setGmtOffset($x->gmt_offset)
//                ->setCountryRus($x->country_rus)
//                ->setCountryEng($x->country_eng)
//                ->setLatitude($x->latitude)
//                ->setLongitude($x->longitude);
//            $em->persist($city);
//            if (($i % 100) == 0) {
//                $em->flush();
//                $em->clear(); // Detaches all objects from Doctrine!
//            }
//        }
//        exit;

        $form = $this->createForm(new SearchForm());

        return $this->render('BundlesDefaultBundle:Default:index.html.twig',['form' => $form->createView()]);
    }

}
