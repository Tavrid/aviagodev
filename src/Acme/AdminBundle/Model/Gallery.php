<?php


namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Gallery extends AbstractModel {
    public function getAll(){

        return $this->getRepository()
            ->createQuery(array('sortByPosition'))
            ->getResult();
    }

    public function findAllFrontend(){
        return $this->getRepository()
            ->createQuery(array('show'))
            ->getResult();
    }
}