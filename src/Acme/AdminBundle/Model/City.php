<?php


namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class City extends AbstractModel {

    public function searchByToken($token){
        $res = array();
        /** @var \Acme\AdminBundle\Entity\City[] $d */
        $d =  $this->getRepository()
            ->createQuery(array('searchByToken' => array($token)))
            ->getResult();
        if($d){
            foreach ($d as $val){
                $res[] = [
                    'id' => $val->getIataCode(),
                    'name' => $val->getCountryRus().', '.$val->getCityRus().' ('.$val->getIataCode().')'
                ];
            }
        }
        return $res;
    }

    public function getFormattedNameByIata($iata){
        $val = $this->getRepository()
            ->findOneBy(array(
                'iata_code' => $iata
            ));
        if($val){
            return $val->getCountryRus().', '.$val->getCityRus().' ('.$val->getIataCode().')';
        }
        return null;
    }

} 