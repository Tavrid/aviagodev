<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:35
 */

namespace Bundles\ApiBundle\Api\Query;

use Bundles\ApiBundle\Api\Model\AviaClassMapping;

class SearchByQuery extends QueryAbstract {

    protected $params;

    /**
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @inheritdoc
     */
    public function buildParams($key)
    {
        //return_way

        $routes = [
            [
                'Departure' => $this->params['city_from_code'],
                'Arrival' => $this->params['city_to_code'],
                'Date' => $this->params['date_from'],
            ],
        ];

        if($this->params['return_way']){
            $routes[]=[
                'Departure' => $this->params['city_to_code'],
                'Arrival' => $this->params['city_from_code'],
                'Date' => $this->params['date_to'],
            ];
        }
        $paramsR = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'AviaSearch',
            'params' => [
                [
                    'Type' => 'Site',
                    'System' => 'Agent',
                    'Key' => $key,
                    'UserIP' => '127.0.0.1',
                    'UserUUID' => ''
                ],
                [
                    'Routes' =>$routes,
                    'Logic' => 'Default',
                    'Class' => AviaClassMapping::getRealClassName($this->params['class']),
                    'Travellers' => [
                            'ADT' => $this->params['adults'],
                            'CHD' => $this->params['children'],
                            'INF' => 0,
                    ],


                ],
                [
                    'Compress' => null,
                    'Format' => 'Combined',
                    'Return' => '',
//                    'Return' => 'ByTimelimit',
                    'Currency' => [
                        $this->params['currency']
                    ],
                    'Language' => 'RU'
                ]
            ]
        ];
        return $paramsR;

    }

    public function getApiUrl(){
        return 'http://ws.demo.webservices.aero/';
    }

    public function getKeyByParams()
    {
        $params = array();
        foreach($this->params as $param){
            if(!empty($param)){
                $params[] = $param;
            }
        }
        return preg_replace('/[ ]+/i','',implode(':',$params));
    }


}