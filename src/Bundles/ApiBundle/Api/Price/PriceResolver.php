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

class PriceResolver implements PriceResolverInterface
{
    /**
     * @inheritdoc
     */
    public function resolve($response,QueryAbstract $query = null)
    {
        $currency = 'RUB';
        if(!is_null($query)){
            $currency = strtoupper($query->getParam('currency'));
        }
        $prices = [];
        if(isset($response['TotalPrice'])){
            $prices[$response['TotalPrice']['Currency']] = $response['TotalPrice'];
        } else {
            $prices['RUB'] = ['Total' => null];
        }

        if(isset($response['TotalPriceConverted'])){
            foreach ($response['TotalPriceConverted'] as $price) {
                $prices[$price['Currency']] = $price;
            }
        }

        if(!isset($prices[$currency])){
            $currency = 'RUB';
        }

        return ['price' => $prices[$currency],'currency' => $currency];

    }


}