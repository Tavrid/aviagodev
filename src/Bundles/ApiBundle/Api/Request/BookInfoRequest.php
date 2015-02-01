<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:02
 */

namespace Bundles\ApiBundle\Api\Request;

use Bundles\ApiBundle\Api\Util\TicketEntityCreator;
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
     * @var \Acme\AdminBundle\Model\Log
     */
    protected $logger;


    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;

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
        $response = new BookInfoResponse(new TicketEntityCreator());
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