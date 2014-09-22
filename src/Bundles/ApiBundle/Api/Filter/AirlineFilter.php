<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:21
 */
namespace Bundles\ApiBundle\Api\Filter;

use Bundles\ApiBundle\Api\Entity\Itineraries;
use Bundles\ApiBundle\Api\Entity\Variants;
use Bundles\ApiBundle\Api\Entity\Segments;
class AirlineFilter extends Filter {


    protected $airline;

    public function __construct($airline){
        $this->airline = $airline;
    }
    public function filterVariant(Variants $variants)
    {
        return true;
    }

    public function filterSegment(Segments $segment)
    {
        if(empty($this->airline)){
            return true;
        }
        return $segment->getMarketingAirline() == $this->airline;
    }

    public function filterItineraries(Itineraries $itineraries)
    {
        return true;
    }

}