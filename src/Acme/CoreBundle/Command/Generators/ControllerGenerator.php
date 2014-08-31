<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.04.14
 * Time: 9:52
 */

namespace Acme\CoreBundle\Command\Generators;


class ControllerGenerator extends GeneratorAbstract {
    protected $useUploader = false;

    public function generate(){
        foreach ($this->generators as $generator){
            $generator->generate();
        }

        $data = array(
            'name' => strtolower($this->entityName),
            'namespace' => $this->getNamespace(),
            'class_name' => $this->getClassName(),
            'form_namespace' => $this->getGenerator(FormGenerator::ALIAS_NAME)->getNamespace(),
            'form_class_name' => $this->getGenerator(FormGenerator::ALIAS_NAME)->getClassName(),
            'service' =>'You bundle directory/Resources/config/services.yml',
            'entity_class' => $this->metadata[0]->getname(),
            'use_uploader' => $this->useUploader
        );
        $this->putContentFromTemplate('Controller.html.twig',$data);
    }

    public function setUseUploader($flag = true){
        $this->useUploader = $flag;
    }



    /**
     * @return string
     */
    public function getFileToCreate()
    {
        $name = ucfirst(strtolower($this->entityName));
        return '/Controller/'.$name.'Controller.php';
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        $rf = new \ReflectionClass($this->bundle);
        return $rf->getNamespaceName().'\\'.'Controller';
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return ucfirst(strtolower($this->entityName)).'Controller';
    }
}