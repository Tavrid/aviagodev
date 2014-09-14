<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 04.09.14
 * Time: 23:11
 */

namespace Bundles\ApiBundle\Api\Entity;


class Itineraries {
    /**
     * @var Variants[]
     */
    protected $variants;

    protected $requestId;

    /**
     * @param $requestId
     * @return $this
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    public function __construct(){
        $this->variants = array();
    }

    /**
     * @param \Bundles\ApiBundle\Api\Entity\Variants[] $variants
     * @return $this
     */
    public function setVariants($variants)
    {
        $this->variants = $variants;
        return $this;
    }

    /**
     * @return \Bundles\ApiBundle\Api\Entity\Variants[]
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @param Variants $variant
     * @return $this
     */
    public function addVariant(Variants $variant){
        $this->variants[] = $variant;
        return $this;
    }



} 