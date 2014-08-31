<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29.03.14
 * Time: 16:42
 */

namespace Acme\AdminBundle\Routing;


class RouteName {

    public static function getRouteName($str){
        $match = preg_match('/([\w]+)Bundle.+\\\([\w]+)Controller\:\:([\w]+)Action/i',$str,$matches);
        return sprintf('%s.%s.%s',strtolower($matches[1]),strtolower($matches[2]),strtolower($matches[3]));
    }

} 