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
use Bundles\ApiBundle\Api\Filter\DirectFlightsFilter;

class SearchFilters {

    public static function getFiltersByParams($params,$additionalParams = []){
//        var_dump($additionalParams['direct_flights'],$params); exit;
        $filters = [];
        if(isset($params['departure_airport'])){
            $filters[] = new DepartureAirportFilter($params['departure_airport']);
        }
        if(isset($params['arrival_airport'])){
            $filters[] = new ArrivalAirportFilter($params['arrival_airport']);
        }
        if(isset($params['airline'])){
            $filters[] = new AirlineFilter($params['airline']);
        } else if(!empty($additionalParams['avia_company']) && $additionalParams['avia_company'] != 'all'){
            $filters[] = new AirlineFilter($additionalParams['avia_company']);
        }
        if(isset($params['departure_time'])){
            $filters[] = new DepartureTimeFilter($params['departure_time']);
        }
        if(isset($params['arrival_time'])){
            $filters[] = new ArrivalTimeFilter($params['arrival_time']);
        }
        if(isset($additionalParams['direct_flights'])){
            $filters[] =  new DirectFlightsFilter($additionalParams['direct_flights']);
        }
        
        return $filters;
    }

} 