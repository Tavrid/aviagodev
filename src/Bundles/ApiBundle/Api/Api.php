<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:44
 */

namespace Bundles\ApiBundle\Api;

use Bundles\ApiBundle\Api\Request\AviaCalendarRequest;
use Bundles\ApiBundle\Api\Request\BookInfoRequest;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
use Bundles\ApiBundle\Api\Request\CityRequest;
use Bundles\ApiBundle\Api\Request\SearchRequest;
use Bundles\ApiBundle\Api\Request\BookRequest;
use Bundles\ApiBundle\Api\Request\AviaFareRulesRequest;
use Bundles\ApiBundle\Api\Request\AviaCheckRequest;

use Bundles\ApiBundle\Api\Model\CacheInterface;

use Acme\CoreBundle\Model\AbstractModel;


class Api {

    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var CacheInterface
     */
    protected $cache;
    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;
    /**
     * @var \Acme\AdminBundle\Model\Log
     */
    protected $logger;
    public function __construct($key,ApiCallerInterface $apiCaller,CacheInterface $cacheInterface = null,AbstractModel $logger){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
        $this->cache = $cacheInterface;
        $this->logger = $logger;

    }

    /**
     * @return CityRequest
     */

    public function getCityRequestor(){
        return new CityRequest($this->apiKey,$this->apiCaller);
    }

    /**
     * @return SearchRequest
     */
    public function getSearchRequestor(){
        $searchRequest = new SearchRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setCache($this->cache);
        $searchRequest->setLogger($this->logger);
        return $searchRequest;
    }

    /**
     * @return BookInfoRequest
     */
    public function getBookInfoRequestor(){
        $searchRequest = new BookInfoRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setLogger($this->logger);
        return $searchRequest;
    }
    /**
     * @return AviaFareRulesRequest
     */
    public function getAviaFareRulesRequestor(){
        $searchRequest = new AviaFareRulesRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setLogger($this->logger);
        return $searchRequest;
    }

    /**
     * @return BookRequest
     */

    public function getBookRequestor(){
        $searchRequest = new BookRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setLogger($this->logger);
        return $searchRequest;
    }

    /**
     * @return AviaCalendarRequest
     */

    public function getAviaCalendarRequestor(){
        $searchRequest = new AviaCalendarRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setLogger($this->logger)
            ->setCache($this->cache);
        return $searchRequest;
    }

    public function getAviaCheckRequestor(){
        $searchRequest = new AviaCheckRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setLogger($this->logger);
        return $searchRequest;
    }

} 