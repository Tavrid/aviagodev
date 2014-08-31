<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.04.14
 * Time: 9:52
 */

namespace Acme\CoreBundle\Command\Generators;


class ViewCreateGenerator extends GeneratorAbstract {

    const ALIAS_NAME = 'view_create';

    public function generate(){
        $data = array(
            'name' => strtolower($this->entityName)
        );
        $this->putContentFromTemplate('ViewCreate.html.twig',$data);
    }



    /**
     * @return string
     */
    public function getFileToCreate()
    {
        $name = ucfirst(strtolower($this->entityName));
        return '/Resources/views/'.$name.'/add.html.twig';
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return null;
    }
}