<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 27.03.14
 * Time: 10:51
 */

namespace Acme\AdminBundle\Repository;
use Acme\CoreBundle\Repository\AbstractRepository;
use Doctrine\ORM\Query\Expr;
class SliderRepository extends AbstractRepository {

    public function sortByPosition(){
        $this->mergeScope(array('orderBy' => 'p.position'));
    }

    public function show(){
        $this->mergeScope(array('where' => 'p.is_show = true'));
    }

    public function avatar(){
//        $this->query->leftJoin('p.media','m',Expr\Join::WITH,'m.avatar = :avatar')
//        ->setParameter('avatar',true);

        $this->mergeScope(array(
            'select' => array('p','m'),
            'leftJoin' => array('p.media','m',Expr\Join::WITH,'m.avatar = true'),
        ));
    }
} 