<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:35
 */

namespace Bundles\ApiBundle\Api\Query;

use Bundles\ApiBundle\Api\Model\AviaClassMapping;

class ComplexSearchByQuery extends QueryAbstract
{

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

        $routes = [];



        foreach($this->params['complexFields'] as $field){
            $routes[] = [
                'Departure' => $field['cityFromCode'],
                'Arrival' => $field['cityToCode'],
                'Date' => $field['date'],
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
                    'Routes' => $routes,
                    'Logic' => 'Default',
                    'Class' => AviaClassMapping::getRealClassName($this->params['class']),
                    'Travellers' => [
                        'ADT' => $this->params['adults'],
                        'CHD' => $this->params['children'],
                        'INF' => $this->params['infant'],
                    ],


                ],
                [
                    'Compress' => null,
                    'Format' => 'Combined',
                    'Timelimit' => 180,
//                    'Return' => '',
                    'Return' => 'ByTimelimit',
                    'Currency' => array('RUB', 'USD', 'EUR','UAH'),
                    'Language' => 'RU'
                ]
            ]
        ];
        return $paramsR;

    }

    /**
     * @inheritdoc
     */
    public function getApiUrl()
    {
        return 'http://ws.demo.webservices.aero/';
    }

    /**
     * @inheritdoc
     */
    public function getKeyByParams()
    {
        $params = array_intersect_key($this->params, [
            'date_from' => '',
            'date_to' => '',
            'class' => '',
            'adults' => '',
            'children' => '',
            'infant' => '',
            ]);
        foreach($this->params['complexFields'] as $field){
            $params[] = $field['cityFromCode'].$field['cityToCode'].$field['date'];

        }
        $params[] = 'AviaComplexSearch';
        return preg_replace('/[ ]+/i', '', implode(':', $params));
    }


}