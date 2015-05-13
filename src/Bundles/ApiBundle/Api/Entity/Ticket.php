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
    protected $requestId;
    protected $totalPrice;
    protected $pricing;
    protected $travelers;
    protected $validatingAirline;
    protected $latinRegistration;
    protected $lastTicketDate;
    protected $currency;
    protected $refundable;
    protected $surnames;

    protected $PNRExpireDate;




    public function __construct() {
        $this->itineraries = array();
    }

    /**
     * @return mixed
     */
    public function getPNRExpireDate()
    {
        return $this->PNRExpireDate;
    }

    /**
     * @param mixed $PNRExpireDate
     * @return $this
     */
    public function setPNRExpireDate($PNRExpireDate)
    {
        $this->PNRExpireDate = $PNRExpireDate;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getSurnames()
    {
        return $this->surnames;
    }

    /**
     * @return bool|float|int|mixed|null|string
     */
    public function getSurname(){
        if(is_array($this->surnames)){
            return current($this->surnames);
        } else if(is_scalar($this->surnames)){
            return $this->surnames;
        }
        return null;
    }

    /**
     * @param $surnames
     * @return $this
     */
    public function setSurnames($surnames)
    {
        $this->surnames = $surnames;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getRefundable()
    {
        return $this->refundable != 'No';
    }

    /**
     * @param $refundable
     * @return $this
     */
    public function setRefundable($refundable)
    {
        $this->refundable = $refundable;
        return $this;
    }


    
    public function getCurrency() {
//        return 'руб.';
        return $this->currency;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    
    /**
     * @return mixed
     */
    public function getLastTicketDate() {
        return $this->lastTicketDate;
    }

    /**
     * @param mixed $lastTicketDate
     * @return $this
     */
    public function setLastTicketDate($lastTicketDate) {
        $this->lastTicketDate = $lastTicketDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatinRegistration() {
        return $this->latinRegistration;
    }

    /**
     * @param mixed $latinRegistration
     * @return $this
     */
    public function setLatinRegistration($latinRegistration) {
        $this->latinRegistration = $latinRegistration;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidatingAirline() {
        return $this->validatingAirline;
    }

    /**
     * @param mixed $validatingAirline
     * @return $this
     */
    public function setValidatingAirline($validatingAirline) {
        $this->validatingAirline = $validatingAirline;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTravelers() {
        return $this->travelers;
    }

    /**
     * @param mixed $travelers
     * @return $this
     */
    public function setTravelers($travelers) {
        $this->travelers = $travelers;
        return $this;
    }

    public function getRoutes($withAirportName = true) {
        $routes = array();
        foreach ($this->getItineraries() as $it) {
            foreach ($it->getVariants() as $var) {
                $segments = $var->getSegments();

                if (count($segments) > 1) {
                    /** @var Segments $f */
                    $f = array_shift($segments);
                    /** @var Segments $l */
                    $l = array_pop($segments);
                } else {
                    $f = $l = array_shift($segments);
                }
                if($withAirportName){
                    $routes[] = $f->getDepartureCityName() . ' (' . $f->getDepartureAirportName() . ')';
                    $routes[] = $l->getArrivalCityName() . ' (' . $l->getArrivalAirportName() . ')';
                } else {
                    $routes[] = $f->getDepartureCityName();
                    $routes[] = $l->getArrivalCityName();
                }
            }
        }
        $c = count($routes) - 1;
        for ($i = 0; $i < $c; $i++) {
            if ($routes[$i] == $routes[$i + 1]) {
                unset($routes[$i]);
            }
        }
        return $routes;
    }

    /**
     * @return mixed
     */
    public function getPricing() {
        return $this->pricing;
    }

    /**
     * @param mixed $pricing
     * @return $this
     */
    public function setPricing($pricing) {
        $this->pricing = $pricing;
        return $this;
    }

    public function getPricingByName($name) {
        foreach ($this->getPricing() as $pricing) {
            if ($pricing['Type'] == $name) {
                return $pricing;
            }
        }
        return [];
    }

    public function getTariffCollection() {
        $pr = 0;
        $total = $this->getTotalPrice();
        foreach ($this->getTravelers() as $name => $count) {
            $pricing = $this->getPricingByName($name);
            if (!empty($pricing['Total'])) {
                if(is_array($count)){
                    $count = count($count);
                }
                $pr+=$pricing['Total'] * $count;
            }
        }

        return $total - $pr;
    }

    /** @param $requestId
     * @return $this
     */
    public function setRequestId($requestId) {
        $this->requestId = $requestId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestId() {
        return $this->requestId;
    }

    /**
     * @param mixed $totalPrice
     * @return $this
     */
    public function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice() {
        return $this->totalPrice;
    }

    /**
     * @param Itineraries[] $itineraries
     * @return $this;
     */
    public function setItineraries($itineraries) {
        $this->itineraries = $itineraries;
        return $this;
    }

    /**
     * @return Itineraries
     */
    public function getFirstItinerarie() {
        $i = $this->getItineraries();
        if (isset($i[0])) {
            return $i[0];
        } else {
            return new Itineraries();
        }
    }

    /**
     * @return Itineraries
     */
    public function getLastItinerarie(){
        $i = $this->getItineraries();
        $n = count($i) - 1;
        if (isset($i[$n])) {
            return $i[$n];
        } else {
            return new Itineraries();
        }
    }

    /**
     * @return \Bundles\ApiBundle\Api\Entity\Itineraries[]
     */
    public function getItineraries() {
        return $this->itineraries;
    }

    /**
     * @param Itineraries $itineraries
     * @return $this
     */
    public function addItineraries(Itineraries $itineraries) {
        $this->itineraries[] = $itineraries;
        return $this;
    }
    
    public function getValidTime(){
        $count = count($this->itineraries);
        if($count > 1){
            return $this->itineraries[$count-1]->getFirstVariant()
                    ->getArrivalSegment()
                    ->getArrivalDate();
        } else if($count == 1){
            return $this->itineraries[$count-1]->getFirstVariant()
                    ->getDepartureSegment()
                    ->getDepartureDate();
        }
        return 0;
    }

}
