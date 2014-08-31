<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.03.14
 * Time: 10:51
 */

namespace Acme\AdminBundle\Repository;
use Acme\CoreBundle\Repository\AbstractRepository;

class MenuRepository extends AbstractRepository {


    public function last($count){
        $this->mergeScope(array('setMaxResults' => $count));
    }

    public function sortByPosition(){
        $this->mergeScope(array('orderBy' => 'p.position'));
    }
} 