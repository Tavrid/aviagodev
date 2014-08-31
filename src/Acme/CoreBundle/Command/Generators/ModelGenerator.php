<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.04.14
 * Time: 9:52
 */

namespace Acme\CoreBundle\Command\Generators;


class ModelGenerator extends GeneratorAbstract {

    const ALIAS_NAME = 'model';

    public function generate(){
        $data = array(
            'name' => strtolower($this->entityName),
            'namespace' => $this->getNamespace(),
            'class_name' => $this->getClassName()
        );
        $this->putContentFromTemplate('Model.html.twig',$data);
    }



    /**
     * @return string
     */
    public function getFileToCreate()
    {
        $name = ucfirst(strtolower($this->entityName));
        return '/Model/'.$name.'.php';
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        $rf = new \ReflectionClass($this->bundle);
        return $rf->getNamespaceName().'\\'.'Model';
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return ucfirst(strtolower($this->entityName));
    }
}