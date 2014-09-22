<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:03
 */

namespace Bundles\ApiBundle\Api\Model;
use Bundles\ApiBundle\Api\Entity\Ticket;
use Bundles\ApiBundle\Api\Filter\AirportFilter;

class SearchFilters {

    public static function getFiltersByParams($params){
        $filters = [
            new AirportFilter()
        ];
        return $filters;
    }

} 