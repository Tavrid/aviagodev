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
class ArrivalAirportFilter extends Filter {


    protected $airport;

    public function __construct($airport){
        $this->airport = $airport;
    }
    public function filterVariant(Variants $variants)
    {
        return true;
    }

    public function filterSegment(Segments $segment)
    {
        if(empty($this->airport) || !$segment->getIsLastSegment()){
            return true;
        }
        return $segment->getArrivalAirport() == $this->airport;
    }

    public function filterItineraries(Itineraries $itineraries)
    {
        return true;
    }

}