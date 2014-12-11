<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 11.12.14
 * Time: 21:33
 */

namespace Bundles\DefaultBundle\Model;


use Acme\AdminBundle\Entity\Order;

class Pay {
    protected $options;
    public function __construct($opt){
        $this->options = $opt;
    }

    public function createForm(Order $order,$payMethod){
        $forSend = array(
            'ORDER_REF' => $order->getOrderId(), # Uniqe order
            'ORDER_PNAME' => array("Test_goods", "Тест товар №1", "Test_goods3"), # Array with data of goods
            'ORDER_PCODE' => array("testgoods1", "testgoods2", "testgoods3"), # Array with codes of goods
            'ORDER_PINFO' => array("", "", ""), # Array with additional data of goods
            'ORDER_PRICE' => array($order->getPrice()), # Array with prices of goods
            'ORDER_QTY' => array(1, 2, 1), # Array with data of counts of each goods
            'PRICES_CURRENCY' => "RUR",  # Currency
            'ORDER_VAT' => array(0, 0, 0),
            'ORDER_SHIPPING' => 0,
            'LANGUAGE' => "RU",
            'PAY_METHOD' => $payMethod
        );

        return PayU::getInst()->setOptions($this->options)->setData($forSend)->LU();
    }
} 