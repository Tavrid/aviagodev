<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.02.15
 * Time: 14:22
 */

namespace Bundles\ApiBundle\Api\Util;


use Bundles\ApiBundle\Api\Entity\Ticket;

interface TicketEntityCreatorInterface {
    /**
     * @param $response
     * @return Ticket
     */
    public function createTicket($response);

}