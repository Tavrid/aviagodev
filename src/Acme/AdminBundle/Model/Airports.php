<?php


namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Airports extends AbstractModel {

    public function searchByToken($token){
        $res = array();
        $r = array();
        /** @var \Acme\AdminBundle\Entity\AviaAirports[] $d */
        $d =  $this->getRepository()
            ->createQuery(array('searchByToken' => array($token)))
            ->getResult();
        if($d){
            foreach ($d as $val){

                $res[$val->getCityCodeEng()][] = [
                    'country' => $val->getCountryRus(),
                    'city' => $val->getCityRus(),
                    'code' => $val->getAirportCodeEng(),
                    'airport' => $val->getAirportRus()
                ];
            }
            foreach($res as $city => $airport){
                if(count($airport) > 1){
                    $f = $airport[0];
                    $r[] = array(
                        'id' => $city,
                        'name' => $f['country'].', '.$f['city'].', Все аэропорты ('.$city.')'
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
        /** @var \Acme\AdminBundle\Entity\AviaAirports[] $results */
        $results = $this->getRepository()
            ->createQuery(['getByCode' => $code])->getResult();

        if($results){
            foreach($results as $val){
                if($code == $val->getCityCodeEng() ||  $code == $val->getAirportCodeEng()){
                    return $val->getCountryRus().', '.$val->getCityRus().' ('.$code.')';
                }
            }
        }
        return null;
    }

} 