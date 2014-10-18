<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 10.04.14
 * Time: 9:53
 */

namespace Acme\CoreBundle\Command\Generators;

use Symfony\Component\HttpKernel\Bundle\Bundle;

abstract class GeneratorAbstract {

    /**
     * @var \Symfony\Component\HttpKernel\Bundle\Bundle
     */
    protected $bundle;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata[]
     */
    protected $metadata;

    /**
     * @var string
     */
    protected $entityName;

    /**
     * @var GeneratorAbstract[]
     */
    protected $generators;

    function __construct(Bundle $bundle, $metadata, $entity) {
        $this->bundle = $bundle;
        $this->metadata = $metadata;
        $this->entityName = $entity;
        $this->init();
    }

    public function init() {
        
    }

    public function putContentFromTemplate($fileTemplate, $data) {
        $fileToCreate = $this->bundle->getPath() . $this->getFileToCreate();
        if (is_file($fileToCreate)) {
            return;
//            throw new \Exception('File exists');
        }
        if (!is_dir(dirname($fileToCreate))) {
            mkdir(dirname($fileToCreate), 0777, true);
        }
        $twig = new \Twig_Environment(new \Twig_Loader_Filesystem(array(__DIR__ . '/sceleton')), array(
            'debug' => true,
            'cache' => false,
            'strict_variables' => true,
            'autoescape' => false,
        ));
        $cont = $twig->render($fileTemplate, $data);
        file_put_contents($fileToCreate, $cont);
    }

    /**
     * @param $name
     * @param GeneratorAbstract $generator
     * @return $this
     */
    public function addGenerator($name, GeneratorAbstract $generator) {
        $this->generators[$name] = $generator;
        return $this;
    }

    /**
     * @param $name
     * @return GeneratorAbstract
     */
    public function getGenerator($name) {
        return $this->generators[$name];
    }

    /**
     * @return mixed
     */
    public abstract function generate();

    /**
     * @return string
     */
    public abstract function getFileToCreate();

    /**
     * @return mixed
     */
    public abstract function getNamespace();

    /**
     * @return mixed
     */
    public abstract function getClassName();
}
