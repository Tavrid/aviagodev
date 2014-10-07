<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:34
 */

namespace Bundles\ApiBundle\Api\Query;


abstract class QueryAbstract {


    protected $params;

    /**
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }


    public abstract function getKeyByParams();

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