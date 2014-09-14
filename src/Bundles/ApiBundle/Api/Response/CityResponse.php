<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 01.09.14
 * Time: 20:18
 */

namespace Bundles\ApiBundle\Api\Response;


class CityResponse extends Response {
    /**
     * @return bool
     */
    public function getIsError()
    {
        return false;
    }


}