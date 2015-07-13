<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 04.09.14
 * Time: 23:29
 */

namespace Bundles\ApiBundle\Api\Entity;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\SerializedName;
/**
 * Class Variants
 * @package Bundles\ApiBundle\Api\Entity
 */
class Variants
{

    /**
     * @var Segments[]
     * @Accessor(getter="getSegments",setter="setSegments")
     */
    protected $segments;
    /**
     * @var int
     * @Accessor(getter="getDuration",setter="setDuration")
     */
    protected $duration;
    /**
     * @var string
     * @Accessor(getter="getVariantID",setter="setVariantID")
     * @SerializedName(value="variant_id")
     */
    protected $variantID;

    /**
     * @param string $variantID
     * @return $this
     */
    public function setVariantID($variantID)
    {
        $this->variantID = $variantID;
        return $this;
    }

    /**
     * @return string
     */
    public function getVariantID()
    {
        return $this->variantID;
    }

    public function __construct()
    {
        $this->segments = array();
    }

    /**
     * @param mixed $duration
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->duration = $duration * 60;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        if ($this->duration == 0) {
            $segments = $this->getSegments();
            foreach ($segments as $i => $segment) {
                $this->duration+=$segment->getFlightTime();
                if(isset($segments[$i+1])){
                    $this->duration+=$segment->getTransplantTime($segments[$i+1]);
                }
            }
        }
        return $this->duration;
    }

    /**
     * @return string
     *
     * TODO надо проверить
     */
    public function getFormattedDuration()
    {
        $t = $this->duration * 60;
        $dataTime = new \DateTime('@' . $t);

        return sprintf('%s ч %s мин', $dataTime->format('H'), $dataTime->format('i'));
    }


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
    public function addSegment(Segments $segment)
    {
        $this->segments[] = $segment;
        return $this;
    }

    public function getCountTransplant()
    {
        return count($this->getSegments()) - 1;
    }

    public function decl($number, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];

    }

    /**
     * @return Segments
     */
    public function getDepartureSegment()
    {
        $segments = $this->getSegments();
        if (!isset($segments[0])) {
            return new Segments();
        }
        return $segments[0];

    }

    /**
     * @return Segments
     */
    public function getArrivalSegment()
    {
        $segments = $this->getSegments();
        $count = count($segments);
        if (!$count) {
            return new Segments();
        }
        if ($count > 1) {
            return $segments[$count - 1];
        } else {
            return $segments[0];
        }
    }

    public function getTransplantAirports()
    {
        $ret = array();

        $segments = $this->getSegments();
        $count = count($segments);
        if ($count > 1) {
            for ($i = 0; $i < ($count - 1); $i++) {
                $ret[] = [
                    'name' => $segments[$i]->getArrivalCityName(),
                    'time' => $segments[$i]->getTransplantTime($segments[$i + 1])
                ];
            }
        }
        return $ret;
    }

    public function getDiffDay(){
        $diff =0;
        $duration = $this->getDuration();
        if(($duration/3600)>24){
            $diff = floor(($duration/3600)/24);
        }
        return $diff;
    }


} 