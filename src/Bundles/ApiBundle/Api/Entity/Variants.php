<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 04.09.14
 * Time: 23:29
 */

namespace Bundles\ApiBundle\Api\Entity;


/**
 * Class Variants
 * @package Bundles\ApiBundle\Api\Entity
 */
class Variants {

    /**
     * @var Segments[]
     */
    protected $segments;
    /**
     * @var int
     */
    protected $duration;
    /**
     * @var string
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

    public function __construct(){
        $this->segments = array();
    }

    /**
     * @param mixed $duration
     * @return $this
     */
    public function setDuration($duration)
    {
        $this->duration = $duration*60;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @return string
     *
     * TODO надо проверить
     */
    public function getFormattedDuration(){
        $t = $this->duration*60;
        $dataTime = new \DateTime('@'.$t);

        return sprintf('%s ч %s мин',$dataTime->format('H'),$dataTime->format('i'));
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
    public function addSegment(Segments $segment){
        $this->segments[] = $segment;
        return $this;
    }

    public function getCountTransplant(){
        return count($this->getSegments()) -1;
    }

    public function decl($number,$titles){
        $cases = array (2, 0, 1, 1, 1, 2);
        return $titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];

    }

    public function getDepartureSegment(){
        $segments = $this->getSegments();
        return array_shift($segments);

    }

    public function getArrivalSegment(){
        $segments = $this->getSegments();
        $count = count($segments);
        if($count > 1){
            return array_pop($segments);
        } else {
            return array_shift($segments);
        }
    }


} 