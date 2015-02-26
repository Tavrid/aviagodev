<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 21.02.15
 * Time: 19:09
 */

namespace Bundles\DefaultBundle\Model;


use Acme\AdminBundle\Entity\Order;

class PirvatApi {
    protected $paiUrl = 'https://api.privatbank.ua/p24api/ishop';

    protected $merchant;
    protected $merchantPass;
    protected $returnUrl;

    public function __construct($merchant,$merchantPass){
        $this->merchant = $merchant;
        $this->merchantPass = $merchantPass;
    }

    public function createForm(Order $order){

        $formData = [
          'amt' => '15.25',//test
            'ccy' => 'UAH',
            'merchant' => trim($this->merchant),
            'order' => '12', //test
            'details' => 'details test',
            'ext_details' => '',//test
            'pay_way' => 'privat24',
            'return_url' => $this->returnUrl,
            'server_url' => '',
        ];


        $sign = $this->generateSignature($formData,$this->merchantPass);
        $formData['signature'] = $sign;

        $str =  '<form action="https://api.privatbank.ua/p24api/ishop" method="POST" accept-charset="UTF-8">';
        foreach ($formData as $key => $val){
            $str.=sprintf('<input type="hidden" name="%s" value="%s"/>',$key,$val);
        }
        $str .='</form>';
        return $str;
    }

    /**
     * @param $formData
     * @param $pass
     * @return string
     */
    private function generateSignature($formData,$pass){
        $params = ['amt','ccy','details','ext_details','pay_way','order','merchant'];
        $str = '';
        foreach ($params as $par){
            $str.=$formData[$par];
        }
        return sha1(md5($str.trim($pass)));

    }
}
