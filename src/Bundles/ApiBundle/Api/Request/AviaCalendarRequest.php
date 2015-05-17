<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:02
 */

namespace Bundles\ApiBundle\Api\Request;

use Bundles\ApiBundle\Api\Model\CacheInterface;
use Bundles\ApiBundle\Api\Model\ResponseTranslatorInterface;
use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
use Bundles\ApiBundle\Api\ApiCall;
use Bundles\ApiBundle\Api\Query\QueryAbstract;
use Bundles\ApiBundle\Api\Response\AviaCalendarResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;


class AviaCalendarRequest implements Request{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;
    /**
     * @var \Acme\AdminBundle\Model\Log
     */
    protected $logger;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var ResponseTranslatorInterface
     */
    protected $responseTranslator;
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * @param $key
     * @param ApiCallerInterface $apiCaller
     * @param ContainerInterface $container
     */
    public function __construct($key ,ApiCallerInterface $apiCaller, ContainerInterface $container){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
        $this->serviceContainer = $container;
    }



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
     * @param \Acme\CoreBundle\Model\AbstractModel $logger
     * @return $this
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
        $response = new AviaCalendarResponse($this->serviceContainer->get('avia.api.ticket_calendar_entity_creator'),$query);
        $response->setServiceContainer($this->serviceContainer);
        $data = null;
        if($this->cache){
            $data = $this->cache->get($query->getKeyByParams());
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