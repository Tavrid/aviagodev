<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 17.11.14
 * Time: 16:08
 */

namespace Bundles\ApiBundle\Api\Model;
use Beryllium\CacheBundle\CacheInterface as InjectCacheInterface;

class Cache implements CacheInterface {
    protected $cacheInterface;
    public function __construct(InjectCacheInterface $cacheInterface){
        $this->cacheInterface = $cacheInterface;
    }
    /**
     * @param $key
     * @param $value
     * @param null $expiration
     * @return $this
     */
    public function set($key, $value, $expiration = null)
    {
        $this->cacheInterface->set($key, $value, $expiration);
        return $this;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->cacheInterface->get($key);
    }


} 