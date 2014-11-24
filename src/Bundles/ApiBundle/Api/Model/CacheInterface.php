<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 17.11.14
 * Time: 15:43
 */

namespace Bundles\ApiBundle\Api\Model;


interface CacheInterface {
    /**
     * @param $key
     * @param $value
     * @param null $expiration
     * @return mixed
     */
    public function set ($key, $value, $expiration = null);

    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

} 