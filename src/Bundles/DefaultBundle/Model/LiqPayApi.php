<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 05.03.15
 * Time: 21:55
 */

namespace Bundles\DefaultBundle\Model;


use Acme\AdminBundle\Entity\Order;

class LiqPayApi
{

    protected $publicKey;
    protected $privateKey;

    public function __construct($publicKey, $privateKey)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    public function createForm(Order $order)
    {

        $liqpay = new \LiqPay($this->publicKey, $this->privateKey);
        $html = $liqpay->cnb_form(array(
            'version' => '3',
            'amount' => $order->getPrice(),
            'currency' => 'RUB',
            'description' => 'Order',
            'order_id' => $order->getId(),
            'sandbox' => 1
        ));
        return $html;
    }


}