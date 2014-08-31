<?php
/**
 * Created by JetBrains PhpStorm.
 * User: root
 * Date: 7/14/13
 * Time: 1:17 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Acme\CoreBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

class EntityListener {
    public function preUpdate(PreUpdateEventArgs $args) {
        if(method_exists($args -> getEntity(),'preUpdate')){
            return call_user_func_array(array($args -> getEntity(),'preUpdate'),array($args));
        }
        return false;

    }

    public function prePersist(LifecycleEventArgs $args) {
        if(method_exists($args -> getEntity(),'prePersist')){
            return call_user_func_array(array($args -> getEntity(),'prePersist'),array($args));
        }
        return false;

    }

    public function postPersist(LifecycleEventArgs $args) {
        if(method_exists($args -> getEntity(),'postPersist')){
            return call_user_func_array(array($args -> getEntity(),'postPersist'),array($args));
        }
        return false;

    }

    public function postRemove(LifecycleEventArgs $args) {
        if(method_exists($args -> getEntity(),'postRemove')){
            return call_user_func_array(array($args -> getEntity(),'postRemove'),array($args));
        }
        return false;
    }

}
