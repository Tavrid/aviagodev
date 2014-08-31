<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ablyakim
 * Date: 19.08.13
 * Time: 21:50
 * To change this template use File | Settings | File Templates.
 */

namespace Acme\MediaBundle\Model;


use Symfony\Component\Security\Acl\Exception\Exception;

class ServiceContainer {

    protected $services;
    protected $defaultParams;
    function __construct($services){
        $this->services = $services['services'];
    }

    public function getService($name){
        if (!isset($this->services[$name])){
            throw new Exception('Error find service');
        }
        return $this->services[$name];
    }


}