<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 11.10.14
 * Time: 14:05
 */

namespace Bundles\ApiBundle\Api\Entity;


class Calendar {
    /**
     * @var Calendar[]
     */
    protected $child;
    /**
     * @var string
     */
    protected $data;
    /**
     * @var float
     */
    protected $price;
    
    protected $currency;

    protected $date;
    /**
     * @var Ticket
     */
    protected $ticket;
    /**
     * @var Calendar
     */
    protected $parent;

    protected $requestId;

    /**
     * @return Calendar
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Calendar $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }



    /**
     * @param $data
     * @param $date
     * @param $isRoot
     */
    public function __construct($data,$date,$isRoot = true){
        $this->data = $data;
        $this->child = array();
        $this->price = isset($data['TotalPrice']['Total']) ? $data['TotalPrice']['Total'] : null;
        $this->date = strtotime($date);
        if($isRoot){
            foreach($data as $de => $da){
                if(!strtotime($de)){
                    continue;
                }
                $calendar = new Calendar($da,$de,false);
                $calendar->setParent($this);
                $this->addChild($calendar);
            }
        }
    }
    public function getCurrency() {
        return 'руб.';
        return $this->currency;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    public function  getRequestId(){
        if($this->parent){
            return $this->parent->getRequestId();
        } else {
            return $this->requestId;
        }
    }

    public function setRequestId($requestId){
        $this->requestId = $requestId;
    }

        /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }



    /**
     * @param Calendar $calendar
     * @return $this
     */
    public function addChild(Calendar $calendar){
        $calendar->setParent($this);
        $this->child[$calendar->getDate()] = $calendar;

        return $this;
    }
    public function findChild($key){
        if(isset($this->child[$key])){
            return $this->child[$key];
        }
        return null;
    }

    /**
     * @return Calendar[]
     */
    public function getChild()
    {
        return $this->child;
    }

    /**
     * @param Calendar[] $child
     * @return $this
     */
    public function setChild($child)
    {
        $this->child = $child;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
    protected function createTicket(){

        $data = $this->getData();

        $ticket = new Ticket();
        $ticket->setRequestId($this->getRequestId());
        $ticket->setTotalPrice($data['TotalPrice']['Total'])
            ->setValidatingAirline($data['ValidatingAirline']);

        foreach($data['Itineraries'] as $inter){
            $it = new Itineraries();
            foreach($inter['Variants'] as $variants){

                $var = new Variants();
                $var->setDuration($variants['Duration'])
                    ->setVariantID($variants['VariantID']);
                $countSegments = count($variants['Segments']);
                $i = 0;
                foreach($variants['Segments'] as $segment){
                    $segm = new Segments();
                    $segm->setArrivalAirportName($segment['ArrivalAirportName'])
                        ->setArrivalCountryName($segment['ArrivalCountryName'])
                        ->setArrivalCityName($segment['ArrivalCityName'])
                        ->setArrivalDate($segment['ArrivalDate'])
                        ->setDepartureCountryName($segment['DepartureCountryName'])
                        ->setDepartureCityName($segment['DepartureCityName'])
                        ->setDepartureAirportName($segment['DepartureAirportName'])
                        ->setDepartureDate($segment['DepartureDate'])
                        ->setAvailableSeats($segment['AvailableSeats'])
                        ->setMarketingAirline($segment['MarketingAirline'])
                        ->setFlightNumber($segment['FlightNumber'])
                        ->setFlightTime($segment['FlightTime'])
                        ->setDepartureTimeZone($segment['DepartureTimeZone'])
                        ->setArrivalTimeZone($segment['ArrivalTimeZone'])
                        ->setMarketingAirlineName($segment['MarketingAirlineName'])
                        ->setDepartureAirport($segment['DepartureAirport'])
                        ->setArrivalAirport($segment['ArrivalAirport'])
                        ->setAircraftName($segment['AircraftName']);

                    if($i == 0){
                        $segm->setIsFirstSegment(true);
                    }
                    $i++;
                    if($countSegments == $i){
                        $segm->setIsLastSegment(true);
                    }
                    $var->addSegment($segm);
                }

                $it->addVariant($var);
            }

            $ticket->addItineraries($it);
        }


        $this->ticket= $ticket;
    }

    /**
     * @return Ticket
     */
    public function getTicket(){
        if(!$this->ticket){
            $this->createTicket();
        }
        return $this->ticket;
    }





} 