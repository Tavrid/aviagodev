<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:35
 */

namespace Bundles\ApiBundle\Api\Query;

use Bundles\ApiBundle\Api\Model\AviaClassMapping;

class SearchByQuery extends QueryAbstract
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

        $routes = [
            [
                'Departure' => $this->params['city_from_code'],
                'Arrival' => $this->params['city_to_code'],
                'Date' => $this->params['date_from'],
            ],
        ];

        if ($this->params['return_way']) {
            $routes[] = [
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
            'city_from_code' => '',
            'city_to_code' => '',
            'date_from' => '',
            'date_to' => '',
            'class' => '',
            'adults' => '',
            'children' => '',
            'infant' => '',
            ]);
        $params[] = 'AviaSearch';
        return preg_replace('/[ ]+/i', '', implode(':', $params));
    }


}