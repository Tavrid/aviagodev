<?php


namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Airports extends AbstractModel {

    public function searchByToken($token){
        $locale = $this->container->get('request')->getLocale();
        /* @var $translator \Symfony\Component\Translation\TranslatorInterface */
        $translator = $this->container->get('translator');
        
        $res = array();
        $r = array();
        /* @var $d \Acme\AdminBundle\Entity\AviaAirports[] */
        $d =  $this->getRepository()
            ->createQuery(array('searchByToken' => array($token)))
            ->getResult();

        if($d){
            
            foreach ($d as $val){
                if($locale == 'en'){
                    
                    $res[$val->getCityCodeEng()][] = [
                        'country' => $val->getCountryEng(),
                        'city' => $val->getCityEng(),
                        'code' => $val->getAirportCodeEng(),
                        'airport' => $val->getAirportEng()
                    ];
                } else {
                    
                    $res[$val->getCityCodeEng()][] = [
                        'country' => $val->getCountryRus(),
                        'city' => $val->getCityRus(),
                        'code' => $val->getAirportCodeEng(),
                        'airport' => $val->getAirportRus()
                    ];
                }
            }
            foreach($res as $city => $airport){
                if(count($airport) > 1){
                    $f = $airport[0];
                    $r[] = array(
                        'id' => $city,
//                        'name' => $f['country'].', '.$f['city'].', Все аэропорты ('.$city.')'
                        'name' => $translator->trans('frontend.default.all_airports',[
                            'country' => $f['country'],
                            'city' => $f['city'],
                            'code' => $city
                                ])
                    );
                }
                foreach($airport as $name){
                    $r[] = array(
                        'id' => $name['code'],
                        'name' => $name['country'].', '.$name['city'].', '.$name['airport'].' ('.$name['code'].')'
                    );
                }
            }
        }
        return $r;
    }

    public function getFormattedNameByIata($code){
        $locale = $this->container->get('request')->getLocale();
        /* @var $results \Acme\AdminBundle\Entity\AviaAirports[]  */
        $results = $this->getRepository()
            ->createQuery(['getByCode' => $code])->getResult();

        if($results){
            foreach($results as $val){
                if($code == $val->getCityCodeEng() ||  $code == $val->getAirportCodeEng()){
                    if($locale == 'en'){
                        return $val->getCountryEng().', '.$val->getCityEng().' ('.$code.')';
                    } else {
                        return $val->getCountryRus().', '.$val->getCityRus().' ('.$code.')';
                    }
                }
            }
        }
        return null;
    }

} 