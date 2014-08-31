<?php

/**
 * CollectionToArray.php (UTF-8)
 *
 * 12.06.2013 17:20:44
 * @author ablyakim
 */

namespace Acme\CoreBundle\Form\Extension;

use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Collections\Collection;


class MultifieldTransformer implements DataTransformerInterface
{

    protected $container;
    protected $field_map;

    public function __construct($field_map)
    {
        $this->field_map = $field_map;
    }

    /**
     * Transforms a collection into an array.
     *
     * @param Collection $collection A collection of entities
     *
     * @return mixed An array of entities
     *
     * @throws TransformationFailedException
     */
    public function transform($data)
    {
        $this->resolveFieldMapping($data, $this->field_map);
        return $data;
    }

    protected function resolveFieldMapping(&$data, $fieldMap)
    {

        foreach ($fieldMap as $field => $map) {
            if (isset($data[$field])) {
                if (in_array('field', $map)) {
                    if (is_array($data[$field])) {
                        unset($data[$field]);
                    }
                } elseif (in_array('multi_field', $map)) {
                    if (!is_array($data[$field])) {
                        unset($data[$field]);
                    }
                } elseif(in_array('sub_multi_field', $map)){
                    $new_data = array();
                    if(isset($data[$field])){
                        $i = 1;
                        foreach ($data[$field] as $val){
                            foreach ($map['fields'] as $f => $c){
                                if(!isset($val[$f]) || is_array($val[$f])){
                                    $val[$f] = null;
                                }
                            }
                            $new_data[$i++] = $val;
                        }
                    }
                    $data[$field] = $new_data;
                } else {
                    $this->resolveFieldMapping($data[$field], $map);
                }
            }
        }

    }

    /**
     * Transforms choice keys into entities.
     *
     * @param mixed $array An array of entities
     *
     * @return Collection   A collection of entities
     */
    public function reverseTransform($array)
    {

        return $array;
    }

}

