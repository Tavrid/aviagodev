<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.03.14
 * Time: 10:47
 */

namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Page extends AbstractModel {

    public function getLast(){
        return $this->getRepository()
            ->createQuery(array('last' => array(1)))->getResult();
    }



} 