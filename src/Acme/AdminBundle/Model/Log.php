<?php


namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Log extends AbstractModel {

    public function addLog($data){
        $entity = $this->getEntity();
        $entity->setInfo($data);
        return $this->save($entity);
    }

} 