<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:03
 */

namespace Bundles\ApiBundle\Api\Model;

use Bundles\ApiBundle\Api\Filter\DepartureAirportFilter;
use Bundles\ApiBundle\Api\Filter\ArrivalAirportFilter;
use Bundles\ApiBundle\Api\Filter\AirlineFilter;
use Bundles\ApiBundle\Api\Filter\DepartureTimeFilter;
use Bundles\ApiBundle\Api\Filter\ArrivalTimeFilter;

class SearchFilters {

    public static function getFiltersByParams($params){
        $filters = [
            new DepartureAirportFilter($params['departure_airport']),
            new ArrivalAirportFilter($params['arrival_airport']),
            new AirlineFilter($params['airline']),
            new DepartureTimeFilter($params['departure_time']),
            new ArrivalTimeFilter($params['arrival_time'])
        ];
        return $filters;
    }

} 