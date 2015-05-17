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
use Bundles\ApiBundle\Api\Response\SearchResponse;
use Acme\CoreBundle\Model\AbstractModel;
use Bundles\ApiBundle\Api\Model\CacheInterface;

use Bundles\ApiBundle\Api\Model\ResponseTranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
     * @var ResponseTranslatorInterface
     */
    protected $responseTranslator;

    /**
     * @return ResponseTranslatorInterface
     */
    public function getResponseTranslator()
    {
        return $this->responseTranslator;
    }

    /**
     * @param ResponseTranslatorInterface $responseTranslator
     * @return $this
     */
    public function setResponseTranslator($responseTranslator)
    {
        $this->responseTranslator = $responseTranslator;
        return $this;
    }

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param CacheInterface $cache
     * @return $this
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
        return $this;
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
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @param $key
     * @param ApiCallerInterface $apiCaller
     */
    public function __construct($key ,ApiCallerInterface $apiCaller,ContainerInterface $container){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
        $this->serviceContainer = $container;
    }


    /**
     * @param AbstractModel $logger
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
        $response = new SearchResponse($this->serviceContainer->get('avia.api.search_entity_creator'),$query);
        $response->setServiceContainer($this->serviceContainer);
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