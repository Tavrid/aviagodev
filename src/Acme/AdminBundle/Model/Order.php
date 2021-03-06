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

    /**
     * @param $pnr
     * @return null|\Acme\AdminBundle\Entity\Order
     */
    public function getOrderBuPnr($pnr){
        if(empty($pnr)){
            return null;
        }
        return $this->getRepository()->findOneBy(array(
            'pnr' => $pnr
        ));
    }

} 