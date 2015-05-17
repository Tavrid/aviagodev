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
    public function resolve(Ticket $ticket, QueryAbstract $query, $response)
    {
        $currency = strtoupper($query->getParam('currency'));
        $prices = [$response['TotalPrice']['Currency'] => $response['TotalPrice']];
        foreach ($response['TotalPriceConverted'] as $price) {
            $prices[$price['Currency']] = $price;
        }
        if(!isset($prices[$currency])){
            $currency = 'RUB';
        }
        $ticket->setTotalPrice($prices[$currency]['Total'])
            ->setCurrency($currency);

    }


}