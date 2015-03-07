<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 05.03.15
 * Time: 21:55
 */

namespace Bundles\DefaultBundle\Model;


use Acme\AdminBundle\Entity\Order;
use Symfony\Component\Routing\RouterInterface;

class LiqPayApi
{

    const SUCCESS_PAY = 'success';
    const FAIL_PAY = 'failure';

    protected $publicKey;
    protected $privateKey;

    protected $router;

    public function __construct($publicKey, $privateKey,RouterInterface $router)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->router = $router;
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
            'sandbox' => 1,
            'result_url' => $this->router->generate('bundles_default_api_return_liqpay',array("orderID" => $order->getOrderId()),true)
        ));
        return $html;
    }

    public function checkStatus(Order $order){
        $liqpay = new \LiqPay($this->publicKey, $this->privateKey);
        $res = $liqpay->api("payment/status", array(
            'version'       => '3',
            'order_id'      => $order->getId()
        ));
        if($res){
            if($res->order_id == $order->getId() && $res->amount == $order->getPrice() && $res->status == self::SUCCESS_PAY){
                return true;
            }
        }
        return false;

    }


}