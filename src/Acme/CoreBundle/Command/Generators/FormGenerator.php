<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.04.14
 * Time: 9:52
 */

namespace Acme\CoreBundle\Command\Generators;


class FormGenerator extends GeneratorAbstract {
    const ALIAS_NAME = 'form';

    public function generate(){
        $data = array(
            'name' => strtolower($this->entityName),
            'fields' => $this->metadata[0]->getFieldNames(),
            'namespace' => $this->getNamespace(),
            'class_name' => $this->getClassName()
        );
        $this->putContentFromTemplate('Form.html.twig',$data);
    }


    /**
     * @return string
     */
    public function getFileToCreate()
    {
        $name = ucfirst(strtolower($this->entityName));
        return '/Form/Type/'.$name.'Type.php';
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        $rf = new \ReflectionClass($this->bundle);
        return $rf->getNamespaceName().'\\'.'Form\\Type';
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return ucfirst(strtolower($this->entityName)).'Type';
    }
}