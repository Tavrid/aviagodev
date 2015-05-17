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

use Bundles\ApiBundle\Api\Model\ResponseTranslatorInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;


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

    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @param $key
     * @param ContainerInterface $container
     */
    public function __construct($key,ContainerInterface $container){
        $this->apiKey = $key;
        $this->apiCaller = $container->get('api_caller');
        $this->cache = $container->get('main.cache');
        $this->logger = $container->get('main.log.manager');
        $this->serviceContainer = $container;
    }

    /**
     * @return CityRequest
     */

    public function getCityRequestor(){
        return new CityRequest($this->apiKey,$this->apiCaller,$this->serviceContainer);
    }

    /**
     * @return SearchRequest
     */
    public function getSearchRequestor(){
        $searchRequest = new SearchRequest($this->apiKey,$this->apiCaller,$this->serviceContainer);
        $searchRequest->setCache($this->cache);
        $searchRequest->setLogger($this->logger);
        return $searchRequest;
    }

    /**
     * @return BookInfoRequest
     */
    public function getBookInfoRequestor(){
        $searchRequest = new BookInfoRequest($this->apiKey,$this->apiCaller,$this->serviceContainer);
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
        $searchRequest = new AviaCalendarRequest($this->apiKey,$this->apiCaller,$this->serviceContainer);
        $searchRequest->setLogger($this->logger)
            ->setCache($this->cache);
        return $searchRequest;
    }

    public function getAviaCheckRequestor(){
        $searchRequest = new AviaCheckRequest($this->apiKey,$this->apiCaller,$this->serviceContainer);
        $searchRequest->setLogger($this->logger);
        return $searchRequest;
    }

} 