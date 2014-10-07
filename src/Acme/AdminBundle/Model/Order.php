<?php


namespace Acme\AdminBundle\Model;
use Acme\CoreBundle\Model\AbstractModel;

class Order extends AbstractModel {

    public function findAllOrders(){
        return $this->getRepository()
            ->createQuery(array('lastItems'))
            ->getResult();
    }

    public function loadModel($id){
        return $this->getRepository()
            ->find($id);
    }

    /**
     * @param $orderId
     * @return \Acme\AdminBundle\Entity\Order
     */
    public function getOrderByOrderId($orderId){
        return $this->getRepository()->findOneBy(array(
           'order_id' => $orderId
        ));
    }

} 