<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:02
 */

namespace Bundles\ApiBundle\Api\Request;

use Bundles\ApiBundle\Api\Util\TicketSearchEntityCreator;
use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
use Bundles\ApiBundle\Api\ApiCall;
use Bundles\ApiBundle\Api\Query\QueryAbstract;
use Bundles\ApiBundle\Api\Response\SearchResponse;
use Acme\CoreBundle\Model\AbstractModel;
use Bundles\ApiBundle\Api\Model\CacheInterface;

class SearchRequest implements Request{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param CacheInterface $cache
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;
    /**
     * @var \Acme\AdminBundle\Model\Log
     */
    protected $logger;

    /**
     * @param $key
     * @param ApiCallerInterface $apiCaller
     */
    public function __construct($key ,ApiCallerInterface $apiCaller){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
    }

    /**
     * @param \Acme\AdminBundle\Model\Log $logger
     * @return $this
     */
    public function setLogger(AbstractModel $logger)
    {
        $this->logger = $logger;
        return $this;
    }



    /**
     * @inheritdoc
     */
    public function execute(QueryAbstract $query)
    {
        $response = new SearchResponse(new TicketSearchEntityCreator());
        $data = null;
        if($this->cache){
            $data = $this->cache
                ->get($query->getKeyByParams());
        }
        if(!$data){
            $data = $this->apiCaller->call(new ApiCall($query->getApiUrl(),json_encode($query->buildParams($this->apiKey))));

            $logParams = [
                'query' => $query->buildParams($this->apiKey),
                'result' => $data
            ];
            $this->logger->addLog($logParams);
            if($this->cache){
                $this->cache->set($query->getKeyByParams(),$data,3600);
            }
        }
        $response->setResponseData($data);
        return $response;
    }
}