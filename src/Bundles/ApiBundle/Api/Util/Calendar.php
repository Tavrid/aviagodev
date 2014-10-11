<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 11.10.14
 * Time: 15:37
 */
namespace Bundles\ApiBundle\Api\Util;
class Calendar {
    public static function createTable($dataFrom,$dataTo){
        $res = array(

        );
        for ($i = -3; $i <=3; $i++){
            $strtotime = strtotime($dataFrom);
            $time = mktime(0, 0, 0, date("m",$strtotime)  , date("d",$strtotime)+($i), date("Y",$strtotime));
            if(strtotime($dataTo) && !empty($dataTo)){
                $toTime = strtotime($dataTo);
                for ($n = -3; $n <=3; $n++){
                    $ttime = mktime(0, 0, 0, date("m",$toTime)  , date("d",$toTime)+($n), date("Y",$toTime));
                    $res[$time][$ttime] = $ttime;
                }
            } else {
                $res[$time] = null;
            }
        }
        return $res;
    }
} 