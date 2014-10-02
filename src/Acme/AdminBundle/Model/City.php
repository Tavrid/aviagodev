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

    public function getByIata($iata){
        return $this->getRepository()
            ->findBy(array(
                'iata' => $iata
            ));
    }

} 