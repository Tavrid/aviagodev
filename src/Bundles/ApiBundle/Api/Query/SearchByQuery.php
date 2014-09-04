<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:35
 */

namespace Bundles\ApiBundle\Api\Query;


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
                    'Routes' => [
                        [
                            'Departure' => 'MOW',
                            'Arrival' => 'LED',
                            'Date' => $this->params['date_from'],
                        ],
                        'Logic' => 'Default',
                        'Class' => $this->params['class'],
                        'Travellers' => [
                                'ADT' => $this->params['adults'],
                                'CHD' => $this->params['children'],
                                'INF' => 0,
                            ],
                        [
                            'Departure' => 'LED',
                            'Arrival' => 'MOW',
                            'Date' => $this->params['date_to'],
                        ]
                    ],
                    'Travellers' => [

                    ]

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
        print_r($paramsR); exit;
        return $paramsR;

    }

    public function getApiUrl(){
        return 'http://ws.demo.webservices.aero/';
    }
}