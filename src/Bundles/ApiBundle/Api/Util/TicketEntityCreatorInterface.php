<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.02.15
 * Time: 14:22
 */

namespace Bundles\ApiBundle\Api\Util;


use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Query\QueryAbstract;

interface TicketEntityCreatorInterface {
    /**
     * @param $response
     * @param QueryAbstract $query
     * @return Ticket
     */
    public function createTicket($response, QueryAbstract $query);

}