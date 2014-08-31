<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.04.14
 * Time: 9:52
 */

namespace Acme\CoreBundle\Command\Generators;


class RepositoryGenerator extends GeneratorAbstract {

    const ALIAS_NAME = 'repository';


    public function generate(){

        $data = array(
            'namespace' => $this->getNamespace(),
            'class_name' => $this->getClassName()
        );
        $this->putContentFromTemplate('Repository.html.twig',$data);
    }



    /**
     * @return string
     */
    public function getFileToCreate()
    {
        $name = ucfirst(strtolower($this->entityName));
        return '/Repository/'.$name.'Repository.php';
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        $rf = new \ReflectionClass($this->bundle);
        return $rf->getNamespaceName().'\\'.'Repository';
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return ucfirst(strtolower($this->entityName)).'Repository';
    }
}