<?php

namespace Acme\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AviaAirports
 */
class AviaAirports
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $favorite;

    /**
     * @var string
     */
    private $iataRegionCode;

    /**
     * @var string
     */
    private $iataTcCode;

    /**
     * @var string
     */
    private $regionCode;

    /**
     * @var string
     */
    private $regionCodeRus;

    /**
     * @var string
     */
    private $regionEng;

    /**
     * @var string
     */
    private $regionRus;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $countryCodeRus;

    /**
     * @var string
     */
    private $countryEng;

    /**
     * @var string
     */
    private $countryRus;

    /**
     * @var string
     */
    private $stateCode;

    /**
     * @var string
     */
    private $stateCodeRus;

    /**
     * @var string
     */
    private $stateEng;

    /**
     * @var string
     */
    private $stateRus;

    /**
     * @var string
     */
    private $cityCodeEng;

    /**
     * @var string
     */
    private $cityCodeRus;

    /**
     * @var string
     */
    private $cityEng;

    /**
     * @var string
     */
    private $cityRus;

    /**
     * @var float
     */
    private $cityLat;

    /**
     * @var float
     */
    private $cityLng;

    /**
     * @var string
     */
    private $cityTimezone;

    /**
     * @var string
     */
    private $airportCodeEng;

    /**
     * @var string
     */
    private $airportCodeRus;

    /**
     * @var string
     */
    private $airportEng;

    /**
     * @var string
     */
    private $airportRus;

    /**
     * @var float
     */
    private $airportLat;

    /**
     * @var float
     */
    private $airportLng;

    /**
     * @var string
     */
    private $timezone;
    /**
     * @var string
     */
    private $shortNameRu;
    /**
     * @var
     */
    private $shortNameEn;
    /**
     * @var
     */
    private $shortNameUk;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set favorite
     *
     * @param boolean $favorite
     * @return AviaAirports
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Get favorite
     *
     * @return boolean 
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * Set iataRegionCode
     *
     * @param string $iataRegionCode
     * @return AviaAirports
     */
    public function setIataRegionCode($iataRegionCode)
    {
        $this->iataRegionCode = $iataRegionCode;

        return $this;
    }

    /**
     * Get iataRegionCode
     *
     * @return string 
     */
    public function getIataRegionCode()
    {
        return $this->iataRegionCode;
    }

    /**
     * Set iataTcCode
     *
     * @param string $iataTcCode
     * @return AviaAirports
     */
    public function setIataTcCode($iataTcCode)
    {
        $this->iataTcCode = $iataTcCode;

        return $this;
    }

    /**
     * Get iataTcCode
     *
     * @return string 
     */
    public function getIataTcCode()
    {
        return $this->iataTcCode;
    }

    /**
     * Set regionCode
     *
     * @param string $regionCode
     * @return AviaAirports
     */
    public function setRegionCode($regionCode)
    {
        $this->regionCode = $regionCode;

        return $this;
    }

    /**
     * Get regionCode
     *
     * @return string 
     */
    public function getRegionCode()
    {
        return $this->regionCode;
    }

    /**
     * Set regionCodeRus
     *
     * @param string $regionCodeRus
     * @return AviaAirports
     */
    public function setRegionCodeRus($regionCodeRus)
    {
        $this->regionCodeRus = $regionCodeRus;

        return $this;
    }

    /**
     * Get regionCodeRus
     *
     * @return string 
     */
    public function getRegionCodeRus()
    {
        return $this->regionCodeRus;
    }

    /**
     * Set regionEng
     *
     * @param string $regionEng
     * @return AviaAirports
     */
    public function setRegionEng($regionEng)
    {
        $this->regionEng = $regionEng;

        return $this;
    }

    /**
     * Get regionEng
     *
     * @return string 
     */
    public function getRegionEng()
    {
        return $this->regionEng;
    }

    /**
     * Set regionRus
     *
     * @param string $regionRus
     * @return AviaAirports
     */
    public function setRegionRus($regionRus)
    {
        $this->regionRus = $regionRus;

        return $this;
    }

    /**
     * Get regionRus
     *
     * @return string 
     */
    public function getRegionRus()
    {
        return $this->regionRus;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     * @return AviaAirports
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string 
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set countryCodeRus
     *
     * @param string $countryCodeRus
     * @return AviaAirports
     */
    public function setCountryCodeRus($countryCodeRus)
    {
        $this->countryCodeRus = $countryCodeRus;

        return $this;
    }

    /**
     * Get countryCodeRus
     *
     * @return string 
     */
    public function getCountryCodeRus()
    {
        return $this->countryCodeRus;
    }

    /**
     * Set countryEng
     *
     * @param string $countryEng
     * @return AviaAirports
     */
    public function setCountryEng($countryEng)
    {
        $this->countryEng = $countryEng;

        return $this;
    }

    /**
     * Get countryEng
     *
     * @return string 
     */
    public function getCountryEng()
    {
        return $this->countryEng;
    }

    /**
     * Set countryRus
     *
     * @param string $countryRus
     * @return AviaAirports
     */
    public function setCountryRus($countryRus)
    {
        $this->countryRus = $countryRus;

        return $this;
    }

    /**
     * Get countryRus
     *
     * @return string 
     */
    public function getCountryRus()
    {
        return $this->countryRus;
    }

    /**
     * Set stateCode
     *
     * @param string $stateCode
     * @return AviaAirports
     */
    public function setStateCode($stateCode)
    {
        $this->stateCode = $stateCode;

        return $this;
    }

    /**
     * Get stateCode
     *
     * @return string 
     */
    public function getStateCode()
    {
        return $this->stateCode;
    }

    /**
     * Set stateCodeRus
     *
     * @param string $stateCodeRus
     * @return AviaAirports
     */
    public function setStateCodeRus($stateCodeRus)
    {
        $this->stateCodeRus = $stateCodeRus;

        return $this;
    }

    /**
     * Get stateCodeRus
     *
     * @return string 
     */
    public function getStateCodeRus()
    {
        return $this->stateCodeRus;
    }

    /**
     * Set stateEng
     *
     * @param string $stateEng
     * @return AviaAirports
     */
    public function setStateEng($stateEng)
    {
        $this->stateEng = $stateEng;

        return $this;
    }

    /**
     * Get stateEng
     *
     * @return string 
     */
    public function getStateEng()
    {
        return $this->stateEng;
    }

    /**
     * Set stateRus
     *
     * @param string $stateRus
     * @return AviaAirports
     */
    public function setStateRus($stateRus)
    {
        $this->stateRus = $stateRus;

        return $this;
    }

    /**
     * Get stateRus
     *
     * @return string 
     */
    public function getStateRus()
    {
        return $this->stateRus;
    }

    /**
     * Set cityCodeEng
     *
     * @param string $cityCodeEng
     * @return AviaAirports
     */
    public function setCityCodeEng($cityCodeEng)
    {
        $this->cityCodeEng = $cityCodeEng;

        return $this;
    }

    /**
     * Get cityCodeEng
     *
     * @return string 
     */
    public function getCityCodeEng()
    {
        return $this->cityCodeEng;
    }

    /**
     * Set cityCodeRus
     *
     * @param string $cityCodeRus
     * @return AviaAirports
     */
    public function setCityCodeRus($cityCodeRus)
    {
        $this->cityCodeRus = $cityCodeRus;

        return $this;
    }

    /**
     * Get cityCodeRus
     *
     * @return string 
     */
    public function getCityCodeRus()
    {
        return $this->cityCodeRus;
    }

    /**
     * Set cityEng
     *
     * @param string $cityEng
     * @return AviaAirports
     */
    public function setCityEng($cityEng)
    {
        $this->cityEng = $cityEng;

        return $this;
    }

    /**
     * Get cityEng
     *
     * @return string 
     */
    public function getCityEng()
    {
        return $this->cityEng;
    }

    /**
     * Set cityRus
     *
     * @param string $cityRus
     * @return AviaAirports
     */
    public function setCityRus($cityRus)
    {
        $this->cityRus = $cityRus;

        return $this;
    }

    /**
     * Get cityRus
     *
     * @return string 
     */
    public function getCityRus()
    {
        return $this->cityRus;
    }

    /**
     * Set cityLat
     *
     * @param float $cityLat
     * @return AviaAirports
     */
    public function setCityLat($cityLat)
    {
        $this->cityLat = $cityLat;

        return $this;
    }

    /**
     * Get cityLat
     *
     * @return float 
     */
    public function getCityLat()
    {
        return $this->cityLat;
    }

    /**
     * Set cityLng
     *
     * @param float $cityLng
     * @return AviaAirports
     */
    public function setCityLng($cityLng)
    {
        $this->cityLng = $cityLng;

        return $this;
    }

    /**
     * Get cityLng
     *
     * @return float 
     */
    public function getCityLng()
    {
        return $this->cityLng;
    }

    /**
     * Set cityTimezone
     *
     * @param string $cityTimezone
     * @return AviaAirports
     */
    public function setCityTimezone($cityTimezone)
    {
        $this->cityTimezone = $cityTimezone;

        return $this;
    }

    /**
     * Get cityTimezone
     *
     * @return string 
     */
    public function getCityTimezone()
    {
        return $this->cityTimezone;
    }

    /**
     * Set airportCodeEng
     *
     * @param string $airportCodeEng
     * @return AviaAirports
     */
    public function setAirportCodeEng($airportCodeEng)
    {
        $this->airportCodeEng = $airportCodeEng;

        return $this;
    }

    /**
     * Get airportCodeEng
     *
     * @return string 
     */
    public function getAirportCodeEng()
    {
        return $this->airportCodeEng;
    }

    /**
     * Set airportCodeRus
     *
     * @param string $airportCodeRus
     * @return AviaAirports
     */
    public function setAirportCodeRus($airportCodeRus)
    {
        $this->airportCodeRus = $airportCodeRus;

        return $this;
    }

    /**
     * Get airportCodeRus
     *
     * @return string 
     */
    public function getAirportCodeRus()
    {
        return $this->airportCodeRus;
    }

    /**
     * Set airportEng
     *
     * @param string $airportEng
     * @return AviaAirports
     */
    public function setAirportEng($airportEng)
    {
        $this->airportEng = $airportEng;

        return $this;
    }

    /**
     * Get airportEng
     *
     * @return string 
     */
    public function getAirportEng()
    {
        return $this->airportEng;
    }

    /**
     * Set airportRus
     *
     * @param string $airportRus
     * @return AviaAirports
     */
    public function setAirportRus($airportRus)
    {
        $this->airportRus = $airportRus;

        return $this;
    }

    /**
     * Get airportRus
     *
     * @return string 
     */
    public function getAirportRus()
    {
        return $this->airportRus;
    }

    /**
     * Set airportLat
     *
     * @param float $airportLat
     * @return AviaAirports
     */
    public function setAirportLat($airportLat)
    {
        $this->airportLat = $airportLat;

        return $this;
    }

    /**
     * Get airportLat
     *
     * @return float 
     */
    public function getAirportLat()
    {
        return $this->airportLat;
    }

    /**
     * Set airportLng
     *
     * @param float $airportLng
     * @return AviaAirports
     */
    public function setAirportLng($airportLng)
    {
        $this->airportLng = $airportLng;

        return $this;
    }

    /**
     * Get airportLng
     *
     * @return float 
     */
    public function getAirportLng()
    {
        return $this->airportLng;
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return AviaAirports
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string 
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
    /**
     * @var string
     */
    private $nameShortRu;

    /**
     * @var string
     */
    private $nameShortEn;

    /**
     * @var string
     */
    private $nameShortUk;


    /**
     * Set nameShortRu
     *
     * @param string $nameShortRu
     * @return AviaAirports
     */
    public function setNameShortRu($nameShortRu)
    {
        $this->nameShortRu = $nameShortRu;

        return $this;
    }

    /**
     * Get nameShortRu
     *
     * @return string 
     */
    public function getNameShortRu()
    {
        return $this->nameShortRu;
    }

    /**
     * Set nameShortEn
     *
     * @param string $nameShortEn
     * @return AviaAirports
     */
    public function setNameShortEn($nameShortEn)
    {
        $this->nameShortEn = $nameShortEn;

        return $this;
    }

    /**
     * Get nameShortEn
     *
     * @return string 
     */
    public function getNameShortEn()
    {
        return $this->nameShortEn;
    }

    /**
     * Set nameShortUk
     *
     * @param string $nameShortUk
     * @return AviaAirports
     */
    public function setNameShortUk($nameShortUk)
    {
        $this->nameShortUk = $nameShortUk;

        return $this;
    }

    /**
     * Get nameShortUk
     *
     * @return string 
     */
    public function getNameShortUk()
    {
        return $this->nameShortUk;
    }
}
