<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 21.09.14
 * Time: 18:45
 */

namespace Acme\CoreBundle\Model;


class ArraySlice {

    public  static function slice($array, $count,$vertical = true){

        $newArray = array();
        if($vertical){
            $i = -1;
            foreach ($array as $key => $val){
                $i++;
                if($i >= $count){
                    $i = 0;
                }
                $newArray[$i][$key] = $val;
            }
        } else {
            $j = 0;
            $i = 0;
            foreach ($array as $key => $val){
                if($j >= $count){
                    $j = 0;
                    $i++;
                }
                $j++;
                $newArray[$i][$key] = $val;
            }
        }
        return $newArray;

    }

} 