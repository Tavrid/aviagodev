<?php


namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Airports extends AbstractModel {

    public function searchByToken($token){
        $res = array();
        /** @var \Acme\AdminBundle\Entity\AviaAirports[] $d */
        $d =  $this->getRepository()
            ->createQuery(array('searchByToken' => array($token)))
            ->getResult();
        if($d){
            foreach ($d as $val){
                $res[] = [
                    'id' => $val->getAirportCodeEng(),
                    'name' => $val->getCountryRus().', '.$val->getCityRus().' ('.$val->getAirportCodeEng().')'
                ];
            }
        }
        return $res;
    }

    public function getFormattedNameByIata($iata){
        $val = $this->getRepository()
            ->findOneBy(array(
                'airportCodeEng' => $iata
            ));
        if($val){
            return $val->getCountryRus().', '.$val->getCityRus().' ('.$val->getIataCode().')';
        }
        return null;
    }

} 