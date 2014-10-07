<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:18
 */

namespace Bundles\ApiBundle\Api\Response;


abstract class Response {
    protected $response;
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

} 