<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 17.05.15
 * Time: 17:57
 */

namespace Bundles\DefaultBundle\Util;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CurrencyManager {
    /**
     * @var SessionInterface
     */
    protected $session;

    const SESSION_CURRENCY_KEY = 'current.currency';

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param $currency
     */
    public function setCurrency($currency)
    {
        if(array_key_exists($currency,$this->getCurrencyList())){
            $this->session->set(self::SESSION_CURRENCY_KEY,$currency);
        }
    }

    public function getCurrency()
    {
        return $this->session->get(self::SESSION_CURRENCY_KEY,'RUB');

    }

    public function getCurrencyList(){
        return [
            'RUB' => 'RUB',
            'USD' => 'USD',
//            'UAH' =>'UAH',
            'EUR' => 'EUR'
        ];
    }

}