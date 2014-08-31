<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 19.01.14
 * Time: 0:30
 */

namespace Acme\CoreBundle\Form\Extension;
use Symfony\Component\Validator\Constraints as Assert;

class FieldMap {

    protected $fieldMap;
    function __construct($fieldMap){
        $this->fieldMap = $this->createFieldMap($fieldMap);
    }

    /**
     * @param $fieldMap
     * @return mixed
     */
    protected function createFieldMap(array $fieldMap){
        foreach ($fieldMap as $key => &$val){
            if(array_key_exists('field',$val) || array_key_exists('multi_field',$val)){
                $newVal = array('field');
                if(isset($val['validator'])){
                    foreach ($val['validator'] as $class => $params){
                        $reflection = new \ReflectionClass($class);
                        if(is_array($params)){
                            $newVal[] = $reflection->newInstanceArgs($params);
                        } else {
                            $newVal[] = $reflection->newInstance();

                        }
                    }
                }
                unset($val['validator']);
                unset($val['field']);
                $val = array_merge($val,$newVal);
            } else if(array_key_exists('sub_multi_field',$val)){
                $val = array_merge($val,array('sub_multi_field','fields'=> $this->createFieldMap($val['fields'])));
                unset($val['sub_multi_field']);
            } else {
                $val = $this->createFieldMap($val);
            }
        }
        return $fieldMap;
    }

    public function getFieldMap(){
        return $this->fieldMap;
    }

} 