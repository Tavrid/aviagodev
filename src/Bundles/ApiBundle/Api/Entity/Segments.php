<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 04.09.14
 * Time: 23:36
 */

namespace Bundles\ApiBundle\Api\Entity;



class Segments {
    /**
     * @var string
     */
    protected $departureCountryName;
    protected $departureCityName;
    protected $departureAirportName;
    protected $departureDate;

    protected $arrivalCountryName;
    protected $arrivalCityName;
    protected $arrivalAirportName;
    protected $arrivalDate;

    protected $availableSeats;


    protected $price;

    protected $flightTime;

    protected $arrivalTimeZone;
    protected $departureTimeZone;


    protected $isFirstSegment;
    protected $isLastSegment;

    protected  $departureTerminal;
    protected $arrivalTerminal;

    protected $departureCity;

    protected $arrivalCity;

    /**
     * @return mixed
     */
    public function getArrivalCity()
    {
        return $this->arrivalCity;
    }

    /**
     * @param $arrivalCity
     * @return $this
     */
    public function setArrivalCity($arrivalCity)
    {
        $this->arrivalCity = $arrivalCity;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartureCity()
    {
        return $this->departureCity;
    }

    /**
     * @param $departureCity
     * @return $this
     */
    public function setDepartureCity($departureCity)
    {
        $this->departureCity = $departureCity;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getIsFirstSegment()
    {
        return $this->isFirstSegment;
    }

    /**
     * @param mixed $isFirstSegment
     * @return $this
     */
    public function setIsFirstSegment($isFirstSegment)
    {
        $this->isFirstSegment = $isFirstSegment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsLastSegment()
    {
        return $this->isLastSegment;
    }

    /**
     * @param mixed $isLastSegment
     * @return $this
     */
    public function setIsLastSegment($isLastSegment)
    {
        $this->isLastSegment = $isLastSegment;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getDepartureTimeZone()
    {
        return $this->departureTimeZone;
    }

    /**
     * @param mixed $departureTimeZone
     * @return $this
     */
    public function setDepartureTimeZone($departureTimeZone)
    {
        $this->departureTimeZone = $departureTimeZone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrivalTimeZone()
    {
        return $this->arrivalTimeZone;
    }

    /**
     * @param mixed $arrivalTimeZone
     * @return $this
     */
    public function setArrivalTimeZone($arrivalTimeZone)
    {
        $this->arrivalTimeZone = $arrivalTimeZone;
        return $this;
    }





    /**
     * @var
     */
    protected $marketingAirline;
    /**
     * @var
     */
    protected $flightNumber;


    protected $marketingAirlineName;

    protected $departureAirport;
    protected $arrivalAirport;

    protected $aircraftName;

    /**
     * @return mixed
     */
    public function getDepartureTerminal()
    {
        return $this->departureTerminal;
    }

    /**
     * @param $departureTerminal
     * @return $this
     */
    public function setDepartureTerminal($departureTerminal)
    {
        $this->departureTerminal = $departureTerminal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrivalTerminal()
    {
        return $this->arrivalTerminal;
    }

    /**
     * @param $arrivalTerminal
     * @return $this
     */
    public function setArrivalTerminal($arrivalTerminal)
    {
        $this->arrivalTerminal = $arrivalTerminal;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getAircraftName()
    {
        return $this->aircraftName;
    }

    /**
     * @param mixed $aircraftName
     * @return $this
     */
    public function setAircraftName($aircraftName)
    {
        $this->aircraftName = $aircraftName;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getArrivalAirport()
    {
        return $this->arrivalAirport;
    }

    /**
     * @param mixed $arrivalAirport
     * @return $this
     */
    public function setArrivalAirport($arrivalAirport)
    {
        $this->arrivalAirport = $arrivalAirport;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getDepartureAirport()
    {
        return $this->departureAirport;
    }

    /**
     * @param mixed $departureAirport
     * @return $this
     */
    public function setDepartureAirport($departureAirport)
    {
        $this->departureAirport = $departureAirport;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getMarketingAirlineName()
    {
        return $this->marketingAirlineName;
    }

    /**
     * @param mixed $marketingAirlineName
     * @return $this
     */
    public function setMarketingAirlineName($marketingAirlineName)
    {
        $this->marketingAirlineName = $marketingAirlineName;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getFlightTime()
    {
//        return $this->arrivalDate - $this->departureDate;
        return $this->flightTime;
    }

    /**
     * @param mixed $flightTime
     * @return $this
     */
    public function setFlightTime($flightTime)
    {
        $this->flightTime = $flightTime*60;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getFlightNumber()
    {
        return $this->flightNumber;
    }

    /**
     * @param mixed $flightNumber
     * @return $this
     */
    public function setFlightNumber($flightNumber)
    {
        $this->flightNumber = $flightNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMarketingAirline()
    {
        return $this->marketingAirline;
    }

    /**
     * @param mixed $marketingAirline
     * @return $this
     */
    public function setMarketingAirline($marketingAirline)
    {
        $this->marketingAirline = $marketingAirline;
        return $this;
    }

    /**
     * @param mixed $availableSeats
     * @return $this
     */
    public function setAvailableSeats($availableSeats)
    {
        $this->availableSeats = $availableSeats;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAvailableSeats()
    {
        return $this->availableSeats;
    }

    /**
     * @param mixed $arrivalAirportName
     * @return $this;
     */
    public function setArrivalAirportName($arrivalAirportName)
    {
        $this->arrivalAirportName = $arrivalAirportName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrivalAirportName()
    {
        return $this->arrivalAirportName;
    }

    /**
     * @param mixed $arrivalCityName
     * @return $this;
     */
    public function setArrivalCityName($arrivalCityName)
    {
        $this->arrivalCityName = $arrivalCityName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrivalCityName()
    {
        return $this->arrivalCityName;
    }

    /**
     * @param mixed $arrivalCountryName
     * @return $this;
     */
    public function setArrivalCountryName($arrivalCountryName)
    {
        $this->arrivalCountryName = $arrivalCountryName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrivalCountryName()
    {
        return $this->arrivalCountryName;
    }

    /**
     * @param mixed $arrivalDate
     * @return $this;
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }



    /**
     * @param mixed $departureAirportName
     * @return $this;
     */
    public function setDepartureAirportName($departureAirportName)
    {
        $this->departureAirportName = $departureAirportName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartureAirportName()
    {
        return $this->departureAirportName;
    }

    /**
     * @param mixed $departureCityName
     * @return $this;
     */
    public function setDepartureCityName($departureCityName)
    {
        $this->departureCityName = $departureCityName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartureCityName()
    {
        return $this->departureCityName;
    }

    /**
     * @param mixed $departureCountryName
     * @return $this;
     */
    public function setDepartureCountryName($departureCountryName)
    {
        $this->departureCountryName = $departureCountryName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartureCountryName()
    {
        return $this->departureCountryName;
    }

    /**
     * @param mixed $departureDate
     * @return $this;
     */
    public function setDepartureDate($departureDate)
    {
        $this->departureDate = $departureDate;
        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }




    /**
     * @param mixed $price
     * @return $this;
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }


    public function getTransplantTime(Segments $next){
        return $next->getDepartureDate() - $this->getArrivalDate();

    }

    protected  function date($date, $format = "d MMMM H:mm")
    {
        if(is_string($date)){
            $date = new \DateTime($date);
        }

        $formatter = new \IntlDateFormatter('ru', \IntlDateFormatter::NONE, \IntlDateFormatter::NONE);
        $formatter->setPattern($format);

        return $formatter->format($date);
    }
} 