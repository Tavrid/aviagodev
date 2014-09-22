<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:03
 */

namespace Bundles\ApiBundle\Api\Model;
use Bundles\ApiBundle\Api\Entity\Ticket;

class SearchFilters {

    public static function getFiltersByParams($params){
        $filters = [
            function(Ticket &$ticket) use ($params){
                $itineraries = $ticket->getItineraries();
                foreach($itineraries as $k => $iter){
                    $variants = $iter->getVariants();
                    foreach($variants  as $k => $variant){
                        $segments = $variant->getSegments();
                        foreach($variant->getSegments() as $k => $segment){
                            if($segment->getArrivalAirport() != 'VKO'){
                                unset($segments[$k]);
                            }
                        }
                        if(empty($segments)){
                            unset($variants[$k]);
                        }

                        $variant->setSegments($segments);

                    }
                    if(empty($variants)){
                        unset($itineraries[$k]);
                    }
                }
                return !empty($itineraries);
            }
        ];
        return $filters;
    }

} 