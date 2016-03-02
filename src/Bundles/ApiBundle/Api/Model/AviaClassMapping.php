<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 11.09.14
 * Time: 11:17
 */

namespace Bundles\ApiBundle\Api\Model;


class AviaClassMapping {
    public static function getRealClassName($cla){
        //Y  C  F
        $names = array(
            'A' => 'Any',
            'E' => 'Econom',
            'B' => 'Business'
        );
        return $names[$cla];

    }
} 