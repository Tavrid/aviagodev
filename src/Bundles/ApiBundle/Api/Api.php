<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:44
 */

namespace Bundles\ApiBundle\Api;
use Bundles\ApiBundle\Api\Request\BookInfoRequest;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
use Bundles\ApiBundle\Api\Request\CityRequest;
use Bundles\ApiBundle\Api\Request\SearchRequest;
use Bundles\ApiBundle\Api\Request\BookRequest;

use Acme\CoreBundle\Model\AbstractModel;


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
    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;
    /**
     * @var \Acme\AdminBundle\Model\Log
     */
    protected $logger;
    public function __construct($key,ApiCallerInterface $apiCaller,\Memcached $memcached,AbstractModel $logger){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
        $this->memcached = $memcached;
        $this->logger = $logger;

    }

    public function getCityRequestor(){
        return new CityRequest($this->apiKey,$this->apiCaller);
    }

    public function getSearchRequestor(){
        $searchRequest = new SearchRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setMemcached($this->memcached)
        ->setLogger($this->logger);
        return $searchRequest;
    }

    public function getBookInfoRequestor(){
        $searchRequest = new BookInfoRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setLogger($this->logger);
        return $searchRequest;
    }

    public function getBookRequestor(){
        $searchRequest = new BookRequest($this->apiKey,$this->apiCaller);
        $searchRequest->setLogger($this->logger);
        return $searchRequest;
    }

} 