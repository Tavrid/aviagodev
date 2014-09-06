<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 06.09.14
 * Time: 2:03
 */

namespace Bundles\ApiBundle\Api\Entity;


class Ticket {
    /**
     * @var Itineraries[]
     */
    protected $itineraries;

    protected $totalPrice;

    public function __construct(){
        $this->itineraries = array();
    }

    /**
     * @param mixed $totalPrice
     * @return $this
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return number_format($this->totalPrice,0,' ',' ');
    }

    /**
     * @param \Bundles\ApiBundle\Api\Entity\Itineraries[] $itineraries
     * @return $this;
     */
    public function setItineraries($itineraries)
    {
        $this->itineraries = $itineraries;
        return $this;
    }

    /**
     * @return \Bundles\ApiBundle\Api\Entity\Itineraries[]
     */
    public function getItineraries()
    {
        return $this->itineraries;
    }

    /**
     * @param Itineraries $itineraries
     * @return $this
     */
    public function addItineraries(Itineraries $itineraries){
        $this->itineraries[] = $itineraries;
        return $this;
    }

} 