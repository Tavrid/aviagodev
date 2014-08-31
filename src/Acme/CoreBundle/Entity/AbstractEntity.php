<?php

/**
 * Description of AbstractEntity
 *
 * @author ablyakim
 * @create 11.05.2013 - 12:42:35
 */

namespace Acme\CoreBundle\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Acme\CoreBundle\Model\Position;
use Acme\CoreBundle\Model\PositionInterface;
class AbstractEntity {
    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args -> getEntity();

        if ($entity instanceof PositionInterface) {
            $changes = $args -> getEntityChangeSet();
            var_dump($changes);exit;
            if(isset($changes['position'])){
                $positionObj = new Position($args -> getEntityManager());

                $oldPosition = $changes['position'][0];
                $positionObj -> updatePosition($entity, $oldPosition);
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args) {
    }

    public function postRemove(LifecycleEventArgs $args) {
        $entity = $args -> getEntity();

        if ($entity instanceof PositionInterface) {
            $positionObj = new Position($args -> getEntityManager());

            $positionObj -> removePosition($entity);
        }
    }

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args -> getEntity();

        if ($entity instanceof PositionInterface) {
            $positionObj = new Position($args -> getEntityManager());

            $positionObj -> insertPosition($entity);
        }
    }

}
