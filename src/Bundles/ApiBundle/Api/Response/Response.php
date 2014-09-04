<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:18
 */

namespace Bundles\ApiBundle\Api\Response;


abstract class Response implements \Iterator ,\ArrayAccess{
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

    public abstract  function getIsError();

} 