<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 04.09.14
 * Time: 23:36
 */

namespace Bundles\ApiBundle\Api\Entity;


class Segments {
    protected $departureCountryName;
    protected $departureCityName;
    protected $departureDateName;
    protected $departureAirportName;
    protected $departureDate;

    protected $arrivalCountryName;
    protected $arrivalCityName;
    protected $arrivalDateName;
    protected $arrivalAirportName;
    protected $arrivalDate;


    protected $price;

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
     * @param mixed $arrivalDateName
     * @return $this;
     */
    public function setArrivalDateName($arrivalDateName)
    {
        $this->arrivalDateName = $arrivalDateName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArrivalDateName()
    {
        return $this->arrivalDateName;
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
     * @return mixed
     */
    public function getDepartureDate()
    {
        return $this->departureDate;
    }

    /**
     * @param mixed $departureDateName
     * @return $this;
     */
    public function setDepartureDateName($departureDateName)
    {
        $this->departureDateName = $departureDateName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDepartureDateName()
    {
        return $this->departureDateName;
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
} 