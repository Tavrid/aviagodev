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

    protected $pricing;

    protected $travelers;

    /**
     * @return mixed
     */
    public function getTravelers()
    {
        return $this->travelers;
    }

    /**
     * @param mixed $travelers
     * @return $this
     */
    public function setTravelers($travelers)
    {
        $this->travelers = $travelers;
        return $this;
    }



    public function __construct()
    {
        $this->itineraries = array();
    }

    public function getRoutes(){
        $routes = array();
        foreach ($this->getItineraries() as $it) {
            foreach($it->getVariants() as $var){
                $segments = $var->getSegments();

                /** @var Segments $f */
                $f = array_shift($segments);
                /** @var Segments $l */
                $l = array_pop($segments);
                $routes[] = $f->getDepartureCityName().' ('.$f->getDepartureAirportName().')';
                $routes[] = $l->getArrivalCityName().' ('.$l->getArrivalAirportName().')';
            }
        }
        $c = count($routes) -1;
        for($i=0; $i < $c; $i++){
            if($routes[$i] == $routes[$i+1]){
                unset($routes[$i]);
            }
        }
        return $routes;
    }

    /**
     * @return mixed
     */
    public function getPricing()
    {
        return $this->pricing;
    }

    /**
     * @param mixed $pricing
     * @return $this
     */
    public function setPricing($pricing)
    {
        $this->pricing = $pricing;
        return $this;
    }

    public function getPricingByName($name){
        foreach($this->getPricing() as $pricing){
            if($pricing['Type'] == $name){
                return $pricing;
            }
        }
        return [];
    }

    public function getTariffCollection(){
        $pr = 0;
        $total = $this->getTotalPrice();
        foreach($this->getTravelers() as $name => $count){
            $pricing = $this->getPricingByName($name);
            $pr+=$pricing['Total']*$count;
        }
        return $total-$pr;
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