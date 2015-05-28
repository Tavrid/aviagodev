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
use Bundles\ApiBundle\Api\Response\CityResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CityRequest implements Request
{
    /**
     * @var string
     */
    protected $apiKey;
    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct($key, ApiCallerInterface $apiCaller, ContainerInterface $container)
    {
        $this->apiKey = $key;
        $this->apiCaller = $apiCaller;
        $this->container = $container;
    }


    /**
     * @inheritdoc
     */
    public function execute(QueryAbstract $query)
    {
        $response = new CityResponse();
        $response->setServiceContainer($this->container);
        $data = $this->apiCaller->call(new ApiCall($query->getApiUrl(),
            json_encode($query->buildParams($this->apiKey))));
        $response->setResponseData($data);

        return $response;
    }
}