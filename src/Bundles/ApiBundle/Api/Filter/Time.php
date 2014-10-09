<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 09.10.14
 * Time: 11:30
 */

namespace Bundles\ApiBundle\Api\Filter;


class Time {
    const TIME_NIGHT = 1;
    const TIME_MORNING = 2;
    const TIME_DAY = 3;
    const TIME_EVENING = 4;

    /**
     * @return array
     */
    public static function  getFilterValues(){
        return [
            self::TIME_NIGHT => 'ночь (00-06)',
            self::TIME_MORNING => 'утро (06-12)',
            self::TIME_DAY => 'день (12-18)',
            self::TIME_EVENING => 'вечер (18-00)',
        ];
    }

    /**
     * @param null $flag
     * @return array
     */
    public static function getMinutes($flag=null){
        $p = [
            self::TIME_NIGHT => [
                'min' => 0,
                'max' => (3600*6)-1
            ],
            self::TIME_MORNING => [
                'min' => 3600*6,
                'max' => (3600*12)-1
            ],
            self::TIME_DAY => [
                'min' => 3600*12,
                'max' => (3600*18)-1
            ],
            self::TIME_EVENING => [
                'min' => 3600*18,
                'max' => (3600*24)-1
            ],
        ];
        if($flag){
            return $p[$flag];
        } else {
            return $p;
        }
    }

    public static function isValidTime($timestamp,$flag){
        $t= self::getMinutes($flag);
        $d = date('H:i',$timestamp);
        $params = explode(':',$d);
        $minutes = ($params[0]*3600)+($params[1]*60);
        if($t['min'] <= $minutes && $t['max'] >= $minutes){
            return true;
        } else {
            return false;
        }
    }

} 