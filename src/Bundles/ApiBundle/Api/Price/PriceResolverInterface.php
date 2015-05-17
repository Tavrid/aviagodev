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

interface PriceResolverInterface {
    /**
     * @param QueryAbstract $query
     * @param $response
     * @return array()
     */
    public function resolve($response,QueryAbstract $query = null);

}