<?php

/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 10.10.14
 * Time: 13:19
 */

namespace Acme\AdminBundle\Model;

use Acme\CoreBundle\Model\AbstractModel;

class Country extends AbstractModel {

    public function getCountries() {
        /** @var \Acme\AdminBundle\Entity\Country[] $data */
        $data = $this->getRepository()
                ->createQuery(array('countryList'))
                ->getResult();
        $res = [];
        foreach ($data as $val) {
            $res[$val->getAlpha2()] = mb_substr($val->getName(), 0, 1, 'UTF-8') . mb_substr(mb_strtolower($val->getName(), 'UTF-8'), 1, null, 'UTF-8');
        }
        return $res;
    }

    public function getMasks() {
        /* @var $val \Acme\AdminBundle\Entity\Country[] */
        $d = $this->getRepository()
                ->createQuery(array('mask'))
                ->getResult();
        
        $data = array();
        
        foreach ($d as $val){
            $data[$val->getAlpha2()] = $val->getPassportMask();
        }
        return $data;
    }

}
