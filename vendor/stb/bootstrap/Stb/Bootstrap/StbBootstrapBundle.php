<?php

namespace Stb\Bootstrap;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

use Stb\Bootstrap\DependencyInjection\Compiler\ColumnTypesPass;

class StbBootstrapBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/Resources/config'));
        $loader->load('assets.yml');


        $container->addCompilerPass(new ColumnTypesPass());
    }
}
