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
use Bundles\ApiBundle\Api\Request\SearchRequest;


class Api {

    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var ApiCallerInterface
     */
    /**
     * @var \Memcached
     */
    protected $memcached;
    protected $apiCaller;
    public function __construct($key,ApiCallerInterface $apiCaller,\Memcached $memcached){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
        $this->memcached = $memcached;

    }

    public function getCityRequestor(){
        return new CityRequest($this->apiKey,$this->apiCaller);
    }

    public function getSearchRequestor(){
        $searchRequest = new SearchRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setMemcached($this->memcached);
        return $searchRequest;
    }

} 