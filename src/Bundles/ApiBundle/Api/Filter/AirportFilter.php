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
class AirportFilter extends Filter {

    public function filterVariant(Variants $variants)
    {
        return true;
    }

    public function filterSegment(Segments $segment)
    {

        return $segment->getDepartureAirport() == 'VKO';
    }

    public function filterItineraries(Itineraries $itineraries)
    {
        return true;
    }

}