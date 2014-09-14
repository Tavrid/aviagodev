<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:35
 */

namespace Bundles\ApiBundle\Api\Query;

use Bundles\ApiBundle\Api\Model\AviaClassMapping;

class BookInfoQuery extends QueryAbstract {

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
            'method' => 'AviaInformation',
            'params' => [
                [
                    'Type' => 'Site',
                    'System' => 'Agent',
                    'Key' => $key,
                    'UserIP' => '127.0.0.1',
                    'UserUUID' => ''
                ],
                [
                    'RequestID' => $this->params['request_id'],
                    'Variants' =>$this->params['variants'],


                ],
                [
                    'Compress' => null,
                    'Format' => 'Combined',
                    'Return' => '',
//                    'Return' => 'ByTimelimit',
                    'Currency' => [
                        'usd'
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
        return null;
    }


}