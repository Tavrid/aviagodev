<?php
/**
 * Created by PhpStorm.
 * User: timur
 * Date: 05.01.15
 * Time: 15:51
 */
namespace Bundles\DefaultBundle\Util;

use Acme\AdminBundle\Model\Airports;

class RouteParams {
    protected $airports;

    public function __construct(Airports $airports){
        $this->airports = $airports;
    }
    public function resolveParams($params){
        $complexFields = [];
        $routes = isset($params['city']) ? explode('_',$params['city']) : [];
        $date = isset($params['date']) ? explode('_',$params['date']) : [];
        foreach($routes as $key => $val){
            $r = explode('-',$val);
            $complexFields[] = [
                'cityFrom' => $this->airports->getFormattedNameByIata($r[0]),
                'cityTo' => $this->airports->getFormattedNameByIata($r[1]),
                'cityFromCode' => $r[0],
                'cityToCode' => $r[1],
                'date' => $date[$key]
            ];
        }
        $params['complexFields'] = $complexFields;
        unset($params['city']);
        unset($params['date']);
        if(isset($params['city_from_code'])){
            $params['city_from'] = $this->airports->getFormattedNameByIata($params['city_from_code']);
        }
        if(isset($params['city_to_code'])){
            $params['city_to'] = $this->airports->getFormattedNameByIata($params['city_to_code']);
        }
        return $params;
    }
}