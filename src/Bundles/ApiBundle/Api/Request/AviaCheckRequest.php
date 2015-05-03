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
use Bundles\ApiBundle\Api\Response\AviaCheckResponse as Response;


class AviaCheckRequest implements Request{
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
     * @param $key
     * @param ApiCallerInterface $apiCaller
     */
    public function __construct($key ,ApiCallerInterface $apiCaller){
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
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
     * @return ResponseTranslatorInterface
     */
    public function getResponseTranslator()
    {
        return $this->responseTranslator;
    }

    /**
     * @param \Acme\AdminBundle\Model\Log $logger
     * @return $this
     */
    public function setLogger(\Acme\CoreBundle\Model\AbstractModel $logger)
    {
        $this->logger = $logger;
        return $this;
    }



   /**
    *
    * @param QueryAbstract $query
    * @return Response
    */
    public function execute(QueryAbstract $query)
    {
        $response = new Response(new TicketEntityCreator($this->responseTranslator));

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