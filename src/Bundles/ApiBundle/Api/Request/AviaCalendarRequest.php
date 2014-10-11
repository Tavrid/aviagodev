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
use Bundles\ApiBundle\Api\Response\AviaCalendarResponse;


class AviaCalendarRequest implements Request{
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
    /**
     * @var \Acme\AdminBundle\Model\Log
     */
    protected $logger;
    public function __construct($key ,ApiCallerInterface $apiCaller){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
    }

    /**
     * @param \Acme\AdminBundle\Model\Log $logger
     */
    public function setLogger(\Acme\CoreBundle\Model\AbstractModel $logger)
    {
        $this->logger = $logger;
        return $this;
    }



    /**
     * @inheritdoc
     */
    public function execute(QueryAbstract $query)
    {
        $response = new AviaCalendarResponse();
        $data = null;
        if($this->memcached){
            $data = $this->memcached->get($query->getKeyByParams());
        }
        if(!$data){
            $data = $this->apiCaller->call(new ApiCall($query->getApiUrl(),json_encode($query->buildParams($this->apiKey))));


            $logParams = [
                'query' => $query->buildParams($this->apiKey),
                'result' => $data
            ];
            $this->logger->addLog($logParams);
            if($this->memcached){
                $this->memcached->set($query->getKeyByParams(),$data,3600);
            }
        }
        $response->setResponseData($data);
        return $response;
    }
}