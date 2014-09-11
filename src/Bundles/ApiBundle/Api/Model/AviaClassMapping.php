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
            'Y' => 'Econom',
            'C' => 'Business',
            'F' => 'First'
        );
        return $names[$cla];

    }
} 