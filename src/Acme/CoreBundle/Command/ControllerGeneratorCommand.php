<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme\CoreBundle\Command;

use Acme\CoreBundle\Command\Generators\FormGenerator;
use Acme\CoreBundle\Command\Generators\ModelGenerator;
use Acme\CoreBundle\Command\Generators\ControllerGenerator;
use Acme\CoreBundle\Command\Generators\RepositoryGenerator;
use Acme\CoreBundle\Command\Generators\ViewCreateGenerator;
use Acme\CoreBundle\Command\Generators\ViewUpdateGenerator;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Command\Command;



use Doctrine\Bundle\DoctrineBundle\Mapping\MetadataFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;

/**
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class ControllerGeneratorCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('ablyakim:generate:crud')
            ->setDescription('Generate crud')
            ->setDefinition(array(
                new InputArgument('entity', InputArgument::REQUIRED, 'The entity'),
                new InputArgument('uploader', InputArgument::REQUIRED, 'The uploader'),

            ));
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        list($bundle,$entity) = explode(':',$input->getArgument('entity'));
        $nameSpace = $this->getDoctrine()->getAliasNamespace($bundle);
        $entityClass = $nameSpace.'\\'.$entity;
        $metadata    = $this->getEntityMetadata($entityClass);

        $bundle      = $this->getContainer()->get('kernel')->getBundle($bundle);
        $useUploader = $input->getArgument('uploader');
        $this->createGenerators($bundle,$metadata,$entity,$useUploader);

        $output->writeln('Ok');
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        $dialog->writeSection($output, 'Welcome to the Ablyakim crud generator');
        $defaultFormat = 'no';

        $routeFormat = $dialog->askAndValidate($output, $dialog->getQuestion('Use uploader (yes, no)', $defaultFormat), function($format){

            $f = strtolower($format);
            if($f == 'yes'){
                return true;
            } else {
                return false;
            }
        }, false, $defaultFormat);
        $input->setArgument('uploader', $routeFormat);

    }
    protected function getDialogHelper()
    {
        $dialog = $this->getHelperSet()->get('dialog');
        if (!$dialog || get_class($dialog) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper') {
            $this->getHelperSet()->set($dialog = new DialogHelper());
        }

        return $dialog;
    }
    protected function createGenerators(Bundle $bundle,$metadata,$entity,$useUploader = false){
        $controllerGenerator = new ControllerGenerator($bundle,$metadata,$entity);
        $controllerGenerator->setUseUploader($useUploader);
        $controllerGenerator->addGenerator(FormGenerator::ALIAS_NAME,new FormGenerator($bundle,$metadata,$entity))
            ->addGenerator(ModelGenerator::ALIAS_NAME,new ModelGenerator($bundle,$metadata,$entity))
            ->addGenerator(RepositoryGenerator::ALIAS_NAME,new RepositoryGenerator($bundle,$metadata,$entity))
            ->addGenerator(ViewCreateGenerator::ALIAS_NAME,new ViewCreateGenerator($bundle,$metadata,$entity))
            ->addGenerator(ViewUpdateGenerator::ALIAS_NAME,new ViewUpdateGenerator($bundle,$metadata,$entity));
        $controllerGenerator->generate();
    }

    /**
     * @param $entity
     * @return \Doctrine\ORM\Mapping\ClassMetadata[]
     */
    protected function getEntityMetadata($entity)
    {
        $factory = new MetadataFactory($this->getContainer()->get('doctrine'));

        return $factory->getClassMetadata($entity)->getMetadata();
    }

    /**
     * Shortcut to return the Doctrine Registry service.
     *
     * @return \Doctrine\Bundle\DoctrineBundle\Registry
     *
     * @throws \LogicException If DoctrineBundle is not available
     */
    public function getDoctrine()
    {
        if (!$this->getContainer()->has('doctrine')) {
            throw new \LogicException('The DoctrineBundle is not registered in your application.');
        }

        return $this->getContainer()->get('doctrine');
    }


}
