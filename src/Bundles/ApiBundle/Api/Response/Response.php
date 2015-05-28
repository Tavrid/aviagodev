<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:18
 */

namespace Bundles\ApiBundle\Api\Response;


use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class Response {
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;
    /**
     * @var
     */
    protected $response;

    /**
     * @return ContainerInterface
     */
    public function getServiceContainer()
    {
        return $this->serviceContainer;
    }

    /**
     * @param ContainerInterface $serviceContainer
     * @return $this
     */
    public function setServiceContainer(ContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
        return $this;
    }




    /**
     * @param $data
     * @return mixed
     */
    public function setResponseData($data)
    {
        // TODO: Implement setResponseData() method.
        $this->response = $data;
    }

    public function getResponseData()
    {
        // TODO: Implement getResponseData() method.
        return $this->response;
    }

    /**
     * @return bool
     */

    public function getIsError()
    {
        if(isset($this->response['errors'])){

            return count($this->response['errors']);
        }
        return false;
    }

    public function getErrors(){
        if(isset($this->response['errors'])){

            return $this->response['errors'];
        }
        return array();
    }

} 