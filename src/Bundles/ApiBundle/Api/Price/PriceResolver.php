<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 17.05.15
 * Time: 13:57
 */

namespace Bundles\ApiBundle\Api\Price;


use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Query\QueryAbstract;
use Bundles\DefaultBundle\Util\CurrencyManager;

class PriceResolver implements PriceResolverInterface
{
    /**
     * @var CurrencyManager
     */
    protected $currencyManager;

    /**
     * @param CurrencyManager $currencyManager
     */
    public function __construct(CurrencyManager $currencyManager)
    {
        $this->currencyManager = $currencyManager;
    }
    /**
     * @inheritdoc
     */
    public function resolve($response,QueryAbstract $query = null)
    {
        $currency = $this->currencyManager->getCurrency();
        $prices = [];
        if(isset($response['TotalPrice'])){
            $prices[$response['TotalPrice']['Currency']] = $response['TotalPrice'];
        } else {
            $prices[$currency] = ['Total' => null];
        }

        if(isset($response['TotalPriceConverted'])){
            foreach ($response['TotalPriceConverted'] as $price) {
                $prices[$price['Currency']] = $price;
            }
        }

        if(!isset($prices[$currency])){
            return ['price' => ['Total' => null],'currency' => $currency];
        }

        return ['price' => $prices[$currency],'currency' => $currency];

    }


}