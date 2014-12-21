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

    protected $name;

    protected $code;

    protected $price;

    protected $orderId;

    protected $payMethod;

    protected $info;

    public function __construct($opt){
        $this->options = $opt;
        $this->name = [];
        $this->code = [];
        $this->info = [];
        $this->price = [];
    }



    public function createForm(){
        $forSend = array(
            'ORDER_REF' => $this->orderId, # Uniqe order
            'ORDER_PNAME' => $this->name, # Array with data of goods
            'ORDER_PCODE' => $this->code, # Array with codes of goods
            'ORDER_PINFO' => $this->info, # Array with additional data of goods
            'ORDER_PRICE' => $this->price, # Array with prices of goods
            'ORDER_QTY' => array(1), # Array with data of counts of each goods
            'PRICES_CURRENCY' => "RUR",  # Currency
            'ORDER_VAT' => array(19),
            'ORDER_SHIPPING' => 0,
            'LANGUAGE' => "RU",
            'PAY_METHOD' => $this->payMethod
        );

        return PayU::getInst()->setOptions($this->options)->setData($forSend)->LU();
    }

    /**
     * @return array
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param array $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param $code
     * @return $this
     */
    public function addCode($code){
        $this->code[] = $code;
        return $this;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param array $info
     * @return $this
     */
    public function setInfo($info)
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @param $info
     * @return $this
     */
    public function addInfo($info){
        $this->info[] = $info;
        return $this;
    }

    /**
     * @return array
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param array $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function addName($name){
        $this->name[] = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param $orderId
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayMethod()
    {
        return $this->payMethod;
    }

    /**
     * @param $payMethod
     * @return $this
     */
    public function setPayMethod($payMethod)
    {
        $this->payMethod = $payMethod;
        return $this;
    }

    /**
     * @return array
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param $price
     * @return $this
     */
    public function addPrice($price){
        $this->price[] = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function test(){
        $forSend = array(
            'ORDER_REF' => '123456', # Uniqe order
            'ORDER_DATE' => '2012-07-25 16:08:21',
            'ORDER_PNAME' => ['some_name1','some_name2'], # Array with data of goods
            'ORDER_PCODE' => ['some_code1','some_code2'], # Array with codes of goods
            'ORDER_PINFO' => ['some_info1','some_info2'], # Array with additional data of goods
            'ORDER_PRICE' => ['123','321'], # Array with prices of goods
            'ORDER_QTY' => array(1,2), # Array with data of counts of each goods
            'PRICES_CURRENCY' => "UAH",  # Currency
            'ORDER_VAT' => array(19,19),
            'ORDER_SHIPPING' => 0,
            'LANGUAGE' => "RU",
            'PAY_METHOD' => 'PRIVATBANK'
        );
        $d = PayU::getInst()->setOptions([
            'merchant' => "payu",
            'secretkey'=> "s9]7K2W|q!X[9k93=f8Z",
            'debug'=> 1
        ])->setData($forSend)->LU();
        return $d;
    }

} 