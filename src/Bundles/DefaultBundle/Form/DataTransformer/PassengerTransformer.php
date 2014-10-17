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


class PassengerTransformer implements DataTransformerInterface{

    /**
     * @inheritdoc
     */
    public function transform($value)
    {
        if(!empty($value)){
            foreach($value as $k => $v){
                if(empty($v)){
                    unset($value[$k]);
                } else {
                    $i = 1;
                    foreach($value[$k] as $key => $val){
                        $t = $value[$k][$key];
                        unset($value[$k][$key]);
                        $value[$k][$i] = $t;
                        $i++;
                    }
                }
            }
        }
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function reverseTransform($value)
    {
        foreach($value as $k => $v){
            if(empty($v)){
                unset($value[$k]);
            } else {
                $i = 0;
                foreach($value[$k] as $key => $val){
                    $t = $value[$k][$key];
                    if(isset($t['Document']['Number'])){
                        $t['Document']['Number'] = preg_replace('/[^a-zA-z0-9]/i','',$t['Document']['Number']);
                    }
                    if(isset($t['Document']['Number'])){
                        $t['Document']['ExpireDate'] = [
                            'day' => $t['Document']['ExpireDate']->format('d'),
                            'year' => $t['Document']['ExpireDate']->format('Y'),
                            'month' => $t['Document']['ExpireDate']->format('m'),
                            
                        ];
                    }
                    if(isset($t['Birthday'])){
                        $t['Birthday'] = [
                            'day' => $t['Birthday']->format('d'),
                            'year' => $t['Birthday']->format('Y'),
                            'month' => $t['Birthday']->format('m'),
                            
                        ];
                    }
                    unset($value[$k][$key]);
                    $value[$k][$i] = $t;
                    $i++;
                }
            }
        }
        $value = $this->ucfirstKeyRecursive($value);
//        var_dump($value); exit;
        return $value;
    }

    protected function ucfirstKeyRecursive($array){
        foreach($array as $key => $val){
            unset($array[$key]);
            if(is_array($val)){
                $array[ucfirst($key)]  = $this->ucfirstKeyRecursive($val);
            } else {
                $array[ucfirst($key)] = $val;
            }
        }
        return $array;
    }
} 