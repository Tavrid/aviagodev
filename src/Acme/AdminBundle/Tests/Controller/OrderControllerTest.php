<?php

namespace Acme\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

//        $crawler = $client->request('POST', '/order/pay-commit');

        $form = array();

// устанавливает какие-нибудь значения
        $form['ik_shop_id'] = 'B68A8A7E-7844-8E9E-852B-E7D8081DE0EF';
        $form['ik_payment_id'] = 2;
        $form['ik_paysystem_alias'] = 'webmoneyz';
        $form['ik_baggage_fields'] = '80441234567';
        $form['ik_payment_timestamp'] = '1196087212';
        $form['ik_payment_state'] = 'success';
        $form['ik_trans_id'] = 'IK_68';
        $form['ik_payment_amount'] = 1;
        $client->request('POST', '/order/pay-commit', $form);
//        $this->assertTrue($client->getResponse());
        var_Dump($client->getResponse());
// отправляет форму
//        $crawler = $client->submit($form);
    }
    /**
     * ik_secret_key : NBgP38jnltBSRxbD
    ik_shop_id : B68A8A7E-7844-8E9E-852B-E7D8081DE0EF
    ik_status_method : POST
    ik_success_method : POST
    ik_fail_method : POST
     *
     * <form action="<Success URL>" method="<Success URL Method>">
    <input type="hidden" name="ik_shop_id" value="64C18529-4B94-0B5D-7405-F2752F2B716C">
    <input type="hidden" name="ik_payment_id" value="1234">
    <input type="hidden" name="ik_paysystem_alias" value="webmoneyz">
    <input type="hidden" name="ik_baggage_fields" value="tel: 80441234567">
    <input type="hidden" name="ik_payment_timestamp" value="1196087212">
    <input type="hidden" name="ik_payment_state" value="success">
    <input type="hidden" name="ik_trans_id" value="IK_68">
    <input type="submit" value="send">
    </form>
     */
}
