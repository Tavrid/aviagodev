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
        if(isset($value['_controller'])){
            unset($value['_controller']);
        }
        if(isset($value['_route'])){
            unset($value['_route']);
        }
        $this->transformBooleanFields($value);

        if(!empty($value['arrivalDate'])){
            $value['arrivalDate'] = new \DateTime($value['arrivalDate']);
        } else {
            $value['arrivalDate'] = null;
        }

        if(!empty($value['departureDate'])){
            $value['departureDate'] = new \DateTime($value['departureDate']);
        } else {
            $value['departureDate'] = null;
        }
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function reverseTransform($value)
    {
        if($value['arrivalDate'] instanceof \DateTime){
            $value['arrivalDate'] = $value['arrivalDate']->format('Y-m-d');
        }
        if(isset($value['departureDate']) && $value['departureDate'] instanceof \DateTime){
            $value['departureDate'] = $value['departureDate']->format('Y-m-d');
        }else {
            $value['departureDate'] = null;
        }
        return $value;
    }

    private function transformBooleanFields(&$value)
    {
        $booleanFields = ['bestPrice','directFlights'];

        foreach($booleanFields as $field){
            if(isset($value[$field])){
                $value[$field] = boolval($value[$field]);
            }
        }
    }

} 