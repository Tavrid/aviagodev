<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:34
 */

namespace Bundles\DefaultBundle\Api;


abstract class QueryAbstract {

    protected $apiKey;

    public function __construct($key){
        $this->apiKey = $key;
    }

    /**
     * @param $params
     * @return array
     */
    abstract function buildParams($params);

} 