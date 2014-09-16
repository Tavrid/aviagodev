<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 06.09.14
 * Time: 2:03
 */

namespace Bundles\ApiBundle\Api\Entity;


class Ticket
{
    /**
     * @var Itineraries[]
     */
    protected $itineraries;
    protected $requestId;

    protected $totalPrice;

    public function __construct()
    {
        $this->itineraries = array();
    }

    /** @param $requestId
     * @return $this
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
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
        return $this->totalPrice;
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
    public function addItineraries(Itineraries $itineraries)
    {
        $this->itineraries[] = $itineraries;
        return $this;
    }

} 