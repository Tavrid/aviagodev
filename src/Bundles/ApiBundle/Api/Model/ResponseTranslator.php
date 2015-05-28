<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 03.05.15
 * Time: 13:55
 */

namespace Bundles\ApiBundle\Api\Model;
use Acme\AdminBundle\Model\Airports;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
class ResponseTranslator implements ResponseTranslatorInterface
{
    /**
     * @var Airports
     */
    protected $airports;
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container){
        $this->airports = $container->get('admin.city.manager');
        $this->container = $container;
    }
    /**
     * @param $airportCode
     * @param $defaultValue
     * @return string
     */
    public function getAirportName($airportCode, $defaultValue)
    {
        $data = $this->airports->getByAirportCode($airportCode);
        if($data){
            $locale = $this->container->get('request')->getLocale();
            if($locale == 'en'){
                return $data->getAirportEng();
            } else {
                return $data->getAirportRus();

            }
        }
        return $defaultValue;
    }

    /**
     * @param $cityCode
     * @param $defaultValue
     * @return string
     */
    public function getCityName($cityCode, $defaultValue)
    {

        $data = $this->airports->getByCityCode($cityCode);
        if($data){
            $locale = $this->container->get('request')->getLocale();
            if($locale == 'en'){
                return $data->getCityEng();
            } else {
                return $data->getCityRus();

            }
        }
        return $defaultValue;
    }

    /**
     * @param $countryCode
     * @param $defaultValue
     * @return mixed
     */
    public function getCountryName($countryCode, $defaultValue)
    {
        return $defaultValue;
    }


}