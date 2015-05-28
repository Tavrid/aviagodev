<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 03.05.15
 * Time: 13:55
 */

namespace Bundles\ApiBundle\Api\Model;


interface ResponseTranslatorInterface {
    /**
     * @param $airportCode
     * @param $defaultValue
     * @return string
     */
    public function getAirportName($airportCode,$defaultValue);

    /**
     * @param $cityCode
     * @param $defaultValue
     * @return string
     */
    public function getCityName($cityCode,$defaultValue);

    /**
     * @param $countryCode
     * @param $defaultValue
     * @return mixed
     */
    public function getCountryName($countryCode,$defaultValue);

}