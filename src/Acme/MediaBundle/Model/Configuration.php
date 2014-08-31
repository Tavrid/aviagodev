<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 30.03.14
 * Time: 14:47
 */

namespace Acme\MediaBundle\Model;


class Configuration {
    protected $params;
    function __construct($params){
        $this->params = $params;
    }

    public function resolveParams(&$params){
        $params = array_replace_recursive($this->params,$params);
    }
} 