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
    protected $departureAirportName;
    protected $departureDate;

    protected $arrivalCountryName;
    protected $arrivalCityName;
    protected $arrivalAirportName;
    protected $arrivalDate;

    protected $availableSeats;


    protected $price;

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
     * @param string $format
     * @return mixed
     */
    public function getArrivalDate($format = "d MMMM H:mm")
    {
        return $this->date($this->arrivalDate,$format);
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
     * @param $format
     * @return mixed
     */
    public function getDepartureDate($format = "d MMMM H:mm")
    {
        return $this->date($this->departureDate,$format);
    }

    /**
     * @return string
     *
     * TODO надо проверить
     */
    public function getFormattedDuration(){
        $t = $this->arrivalDate - $this->departureDate;
        $dataTime = new \DateTime('@'.$t);

        return sprintf('%s ч %s мин',$dataTime->format('H'),$dataTime->format('i'));
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