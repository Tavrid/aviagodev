<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 10.10.14
 * Time: 16:15
 */


namespace Bundles\DefaultBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;


class SearchFormTransformer implements DataTransformerInterface{

    /**
     * @inheritdoc
     */
    public function transform($value)
    {
        if(!empty($value['date_from'])){
            $value['date_from'] = new \DateTime($value['date_from']);
        } else {
            $value['date_from'] = null;
        }

        if(!empty($value['date_to'])){
            $value['date_to'] = new \DateTime($value['date_to']);
        } else {
            $value['date_to'] = null;
        }
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function reverseTransform($value)
    {
        if($value['date_from'] instanceof \DateTime){
            $value['date_from'] = $value['date_from']->format('Y-m-d');
        }
        if(isset($value['date_to']) && $value['date_to'] instanceof \DateTime){
            $value['date_to'] = $value['date_to']->format('Y-m-d');
        }else {
            $value['date_to'] = null;
        }
        return $value;
    }

} 