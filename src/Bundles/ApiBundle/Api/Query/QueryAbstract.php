<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:34
 */

namespace Bundles\ApiBundle\Api\Query;


abstract class QueryAbstract {


    public function __construct(){
    }

    /**
     * @param $key
     * @return mixed
     */
    abstract function buildParams($key);

    /**
     * @return mixed
     */
    abstract function getApiUrl();

} 