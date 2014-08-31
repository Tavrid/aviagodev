<?php

/**
 * GoodsItems.php (UTF-8)
 *
 * Jun 23, 2013 7:43:52 PM
 * @author abdulhakim
 */

namespace Acme\CoreBundle\Model;

use \Doctrine\ORM\EntityManager;
use Symfony\Component\PropertyAccess\PropertyAccess;
use \Doctrine\ORM\QueryBuilder;

class Position {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;


    public function __construct(EntityManager $em) {
        $this->em = $em;
    }


    public function updatePosition(PositionInterface $entity,$oldPosition){
        $position = $entity->getPosition();
        $qb = $this->em->createQueryBuilder();

        $qb -> update(get_class($entity), 'u');

        if ($position > $oldPosition) {
            $qb->where('u.position <= :position AND u.position >= :oldPosition');
            $positionExpr = $qb -> expr() -> diff('u.position', 1);

        } else {
            $qb->where('u.position>=:position AND u.position <= :oldPosition');
            $positionExpr = $qb -> expr() -> sum('u.position', 1);
        }

        $qb-> set('u.position', $positionExpr)
            ->setParameters(array('position' => $position,'oldPosition' => $oldPosition));
        $this->addCondition($qb,$entity);
        $q = $qb -> getQuery();
        return $q -> getResult();
    }

    public function insertPosition(PositionInterface $entity) {
        $position = $entity->getPosition();

        $qb = $this->em->createQueryBuilder();
        $qb -> update(get_class($entity), 'u');
        $qb -> where('u.position >= :position');
        $positionExpr = $qb -> expr() -> sum('u.position', 1);


        $qb -> set('u.position', $positionExpr)
            -> setParameter('position', $position);
        $this->addCondition($qb,$entity);

        $q = $qb -> getQuery();
        return $q -> getResult();

    }

    public function removePosition(PositionInterface $entity) {
        $position = $entity->getPosition();
        $qb = $this->em->createQueryBuilder();
        $qb -> update(get_class($entity), 'u');
        $positionExpr = $qb -> expr() -> diff('u.position', 1);
        $qb -> where('u.position > :position')
            -> setParameter('position', $position)
            -> set('u.position', $positionExpr);
        $this->addCondition($qb,$entity);
        $q = $qb -> getQuery();
        return $q -> getResult();
    }

    private function addCondition(QueryBuilder &$qb,PositionInterface $entity){

        $addAttr = $entity->getAdditionalFields();
        $prAccess = PropertyAccess::createPropertyAccessor();

        foreach ($addAttr as $key => $val){
            if(!is_string($key)){
                $key = $val;
                $val = $prAccess->getValue($entity,$val);
            }
            if($key === null){
                $qb->andWhere('u.'.$key.' = :'.$key)
                    -> setParameter($key, $val);
            } else {
                $qb->andWhere($qb->expr()->isNull('u.'.$key.''));
            }
        }
    }


}
