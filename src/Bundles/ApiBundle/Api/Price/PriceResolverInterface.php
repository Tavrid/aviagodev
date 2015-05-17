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

    public function resolve(Ticket $ticket, QueryAbstract $query,$response);

}