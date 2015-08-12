<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 12.08.15
 * Time: 20:58
 */

namespace Bundles\DefaultBundle\Model;


use Bundles\ApiBundle\Api\Model\CacheInterface;

class FLightData
{

    protected $cache;

    /**
     * FLightData constructor.
     */
    public function __construct(CacheInterface $cacheInterface)
    {
        $this->cache = $cacheInterface;
    }

    /**
     * @param $formData
     * @return string
     */
    public function setData($formData){
        $key = uniqid();
        $this->cache->set($key,$formData,60*60);
        return $key;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getData($key)
    {
        return $this->cache->get($key);
    }
}