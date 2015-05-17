<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:02
 */

namespace Bundles\ApiBundle\Api\Request;

use Bundles\ApiBundle\Api\Model\ResponseTranslatorInterface;
use Bundles\ApiBundle\Api\Util\TicketEntityCreator;
use Lsw\ApiCallerBundle\Caller\ApiCallerInterface;
use Bundles\ApiBundle\Api\ApiCall;
use Bundles\ApiBundle\Api\Query\QueryAbstract;
use Bundles\ApiBundle\Api\Response\BookInfoResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;


class BookInfoRequest implements Request{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var \Acme\AdminBundle\Model\Log
     */
    protected $logger;


    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;

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
        $response = new BookInfoResponse($this->serviceContainer->get('avia.api.ticket_entity_creator'));
        $response->setServiceContainer($this->serviceContainer);
        $data = $this->apiCaller->call(new ApiCall($query->getApiUrl(),json_encode($query->buildParams($this->apiKey))));
        $response->setResponseData($data);
        $logParams = [
            'query' => $query->buildParams($this->apiKey),
            'result' => $data
        ];
        $this->logger->addLog($logParams);
//        file_put_contents(__DIR__.'/../Examples/book_info.json',json_encode($data));
        return $response;
    }
}