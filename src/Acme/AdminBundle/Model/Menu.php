<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.03.14
 * Time: 10:47
 */

namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Menu extends AbstractModel {

    public function getAll(){

        return $this->getRepository()
            ->createQuery(array('sortByPosition'))
            ->getResult();
    }

    public function getTree(){
        return $this->getRepository()
            ->createQuery(array('createBaseTree'))
            ->getResult();
    }



} 