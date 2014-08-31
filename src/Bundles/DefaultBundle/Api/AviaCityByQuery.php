<?php
/**
 * Created by PhpStorm.
 * User: ablyakim
 * Date: 31.08.14
 * Time: 19:35
 */

namespace Bundles\DefaultBundle\Api;


class AviaCityByQuery extends QueryAbstract {

    /**
     * @inheritdoc
     */
    public function buildParams($params)
    {
        $paramsR = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'method' => 'AviaCityByQuery',
            'params' => [
                [
                    'Type' => 'Site',
                    'System' => 'Agent',
                    'Key' => $this->apiKey,
                    'UserIP' => '127.0.0.1',
                    'UserUUID' => ''
                ],
                $params['query'],
                [
                    'Return' => '',
                    'Language' => 'RU'
                ]
            ]
        ];
        return $paramsR;

    }
}