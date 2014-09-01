<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:44
 */

namespace Bundles\ApiBundle\Api;
use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
use Bundles\ApiBundle\Api\Request\CityRequest;


class Api {

    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;
    public function __construct($key,ApiCallerInterface $apiCaller){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;

    }

    public function getCityRequestor(){
        return new CityRequest($this->apiKey,$this->apiCaller);
    }

} 