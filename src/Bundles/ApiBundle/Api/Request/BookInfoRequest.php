<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:02
 */

namespace Bundles\ApiBundle\Api\Request;

use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
use Bundles\ApiBundle\Api\ApiCall;
use Bundles\ApiBundle\Api\Query\QueryAbstract;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;


class BookInfoRequest implements Request{
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var \Memcached
     */
    protected $memcached;

    /**
     * @param \Memcached $memcached
     * @return $this
     */
    public function setMemcached(\Memcached $memcached)
    {
        $this->memcached = $memcached;
        return $this;
    }

    /**
     * @return \Memcached
     */
    public function getMemcached()
    {
        return $this->memcached;
    }
    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;
    public function __construct($key ,ApiCallerInterface $apiCaller){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
    }



    /**
     * @inheritdoc
     */
    public function execute(QueryAbstract $query)
    {
        $response = new BookInfoResponse();
        $data = $this->apiCaller->call(new ApiCall($query->getApiUrl(),json_encode($query->buildParams($this->apiKey))));
        $response->setResponseData($data);
        return $response;
    }
}