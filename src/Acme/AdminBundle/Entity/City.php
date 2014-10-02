<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 02.10.14
 * Time: 15:44
 */

namespace Acme\AdminBundle\Entity;
use Acme\CoreBundle\Entity\AbstractEntity;

class City extends AbstractEntity {

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $iata_code;

    /**
     * @var string
     */
    private $name_rus;

    /**
     * @var string
     */
    private $name_eng;

    /**
     * @var string
     */
    private $city_rus;

    /**
     * @var string
     */
    private $city_eng;

    /**
     * @var string
     */
    private $gmt_offset;

    /**
     * @var string
     */
    private $country_rus;

    /**
     * @var string
     */
    private $country_eng;

    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;


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
     * Set iata_code
     *
     * @param string $iataCode
     * @return City
     */
    public function setIataCode($iataCode)
    {
        $this->iata_code = $iataCode;

        return $this;
    }

    /**
     * Get iata_code
     *
     * @return string 
     */
    public function getIataCode()
    {
        return $this->iata_code;
    }

    /**
     * Set name_rus
     *
     * @param string $nameRus
     * @return City
     */
    public function setNameRus($nameRus)
    {
        $this->name_rus = $nameRus;

        return $this;
    }

    /**
     * Get name_rus
     *
     * @return string 
     */
    public function getNameRus()
    {
        return $this->name_rus;
    }

    /**
     * Set name_eng
     *
     * @param string $nameEng
     * @return City
     */
    public function setNameEng($nameEng)
    {
        $this->name_eng = $nameEng;

        return $this;
    }

    /**
     * Get name_eng
     *
     * @return string 
     */
    public function getNameEng()
    {
        return $this->name_eng;
    }

    /**
     * Set city_rus
     *
     * @param string $cityRus
     * @return City
     */
    public function setCityRus($cityRus)
    {
        $this->city_rus = $cityRus;

        return $this;
    }

    /**
     * Get city_rus
     *
     * @return string 
     */
    public function getCityRus()
    {
        return $this->city_rus;
    }

    /**
     * Set city_eng
     *
     * @param string $cityEng
     * @return City
     */
    public function setCityEng($cityEng)
    {
        $this->city_eng = $cityEng;

        return $this;
    }

    /**
     * Get city_eng
     *
     * @return string 
     */
    public function getCityEng()
    {
        return $this->city_eng;
    }

    /**
     * Set gmt_offset
     *
     * @param string $gmtOffset
     * @return City
     */
    public function setGmtOffset($gmtOffset)
    {
        $this->gmt_offset = $gmtOffset;

        return $this;
    }

    /**
     * Get gmt_offset
     *
     * @return string 
     */
    public function getGmtOffset()
    {
        return $this->gmt_offset;
    }

    /**
     * Set country_rus
     *
     * @param string $countryRus
     * @return City
     */
    public function setCountryRus($countryRus)
    {
        $this->country_rus = $countryRus;

        return $this;
    }

    /**
     * Get country_rus
     *
     * @return string 
     */
    public function getCountryRus()
    {
        return $this->country_rus;
    }

    /**
     * Set country_eng
     *
     * @param string $countryEng
     * @return City
     */
    public function setCountryEng($countryEng)
    {
        $this->country_eng = $countryEng;

        return $this;
    }

    /**
     * Get country_eng
     *
     * @return string 
     */
    public function getCountryEng()
    {
        return $this->country_eng;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return City
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return City
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
