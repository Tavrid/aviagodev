<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 04.09.14
 * Time: 23:11
 */

namespace Bundles\ApiBundle\Api\Entity;

use JMS\Serializer\Annotation\Accessor;

class Itineraries {
    /**
     * @var Variants[]
     * @Accessor(getter="getVariants",setter="setVariants")
     */
    protected $variants;



    /**


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
     * @return \Bundles\ApiBundle\Api\Entity\Variants
     */
    public function getFirstVariant(){
        $var = $this->getVariants();
        if(isset($var[0])){
            return $var[0];
        } else {
            return new Variants();
        }
    }
    /**
     * @return \Bundles\ApiBundle\Api\Entity\Variants
     */
    public function getLastVariant(){
        $var = $this->getVariants();
        $key = count($var) - 1;
        if(isset($var[$key])){
            return $var[$key];
        } else {
            return new Variants();
        }
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