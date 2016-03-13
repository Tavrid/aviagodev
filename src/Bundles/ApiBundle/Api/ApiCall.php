<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 30.08.14
 * Time: 23:52
 */

namespace Bundles\ApiBundle\Api;
use Lsw\ApiCallerBundle\Call\HttpGetXML;

class ApiCall  extends HttpGetXML{
//    protected $asAssociativeArray = true;

    /**
     * {@inheritdoc}
     */
    public function generateRequestData()
    {
        $this->requestData = $this->requestObject;
    }

    /**
     * {@inheritdoc}
     */
    public function parseResponseData()
    {
        $this->responseObject = json_decode($this->responseData,true);
    }

} 
