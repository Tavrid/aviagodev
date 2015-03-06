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
            'result_url' => $this->router->generate('bundles_default_api_order',array("orderID" => $order->getOrderId()),true)
        ));
        return $html;
    }


}