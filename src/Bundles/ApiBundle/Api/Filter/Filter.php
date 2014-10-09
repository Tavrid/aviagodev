<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:19
 */
namespace Bundles\ApiBundle\Api\Filter;
use Bundles\ApiBundle\Api\Entity\Ticket;

abstract class Filter {
    public abstract function filterItem(Ticket &$ticket);

}