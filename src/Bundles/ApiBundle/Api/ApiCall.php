<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 30.08.14
 * Time: 23:52
 */

namespace Bundles\ApiBundle\Api;
use Lsw\ApiCallerBundle\Call\HttpPostJson;

class ApiCall  extends HttpPostJson{

    /**
     * {@inheritdoc}
     */
    public function generateRequestData()
    {
        $this->requestData = $this->requestObject;
    }

} 