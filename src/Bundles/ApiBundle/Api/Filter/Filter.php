<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 22.09.14
 * Time: 21:19
 */
namespace Bundles\ApiBundle\Api\Filter;
use Bundles\ApiBundle\Api\Entity\Segments;
use Bundles\ApiBundle\Api\Entity\Variants;
use Bundles\ApiBundle\Api\Entity\Itineraries;

abstract class Filter {
    public abstract function filterVariant(Variants $variants);
    public abstract function filterSegment(Segments $segment);
    public abstract function filterItineraries(Itineraries $itineraries);
}