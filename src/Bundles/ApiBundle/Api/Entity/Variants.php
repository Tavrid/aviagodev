<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 04.09.14
 * Time: 23:29
 */

namespace Bundles\ApiBundle\Api\Entity;


class Variants {

    /**
     * @var Segments[]
     */
    protected $segments;
    /**
     * @param \Bundles\ApiBundle\Api\Entity\Segments[] $segments
     * @return $this;
     */
    public function setSegments($segments)
    {
        $this->segments = $segments;
        return $this;
    }

    /**
     * @return \Bundles\ApiBundle\Api\Entity\Segments[]
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     * @param Segments $segment
     * @return $this;
     */
    public function addSegment(Segments $segment){
        $this->segments[] = $segment;
        return $this;
    }


} 