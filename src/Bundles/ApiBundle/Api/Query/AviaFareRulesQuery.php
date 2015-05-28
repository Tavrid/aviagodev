<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 26.01.15
 * Time: 9:58
 */

namespace Bundles\ApiBundle\Api\Query;


class AviaFareRulesQuery extends QueryAbstract{
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
     * @return string return uniq key by request params
     */
    public function getKeyByParams()
    {
        return null;
    }

    /**
     * @param $key
     * @return array
     */
    function buildParams($key)
    {
        $paramsR = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'AviaFareRules',
            'params' => [
                [
                    'Type' => 'Site',
                    'System' => 'Agent',
                    'Key' => $key,
                    'UserIP' => '127.0.0.1',
                    'UserUUID' => ''
                ],
                [
                    'Follow' => 'SearchResults',
                    'RequestID' => $this->params['request_id'],
                    'Variants' =>$this->params['variants'],


                ],
                [
                    'Compress' => null,
                    'Format' => 'Combined',
                    'Return' => '',
//                    'Return' => 'ByTimelimit',
                    'Currency' => array('RUB','USD','EUR','UAH'),
                    'Language' => 'RU'
                ]
            ]
        ];
        return $paramsR;
    }

    /**
     * @return mixed
     */
    function getApiUrl()
    {
        return 'http://ws.demo.webservices.aero/';
    }


} 