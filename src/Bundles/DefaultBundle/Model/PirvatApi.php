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

    public function createForm(Order $order){


        return '<form action="https://api.privatbank.ua/p24api/ishop" method="POST" accept-charset="UTF-8">
                  <input type="hidden" name="amt" value="15.25"/>
                  <input type="hidden" name="ccy" value="UAH" />
                  <input type="hidden" name="merchant" value="75482" />
                  <input type="hidden" name="order" value="000AB1502ZGH" />
                  <input type="hidden" name="details" value="книга Будь здоров!" />
                  <input type="hidden" name="ext_details" value="1000BDN01" />
                  <input type="hidden" name="pay_way" value="privat24" />
                  <input type="hidden" name="return_url" value="https://mysite.net/papi/rurl.php" />
                  <input type="hidden" name="server_url" value="" />
                  <input type="hidden" name="signature" value="3A90E5J0f6OUIfqN1Qu59gYrjDgDblfL" />
                  <input type="submit" value="Оплатить" />
                </form>';
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
        return sha1(md5($str.$pass));

    }
}
