<?php

namespace Bundles\DefaultBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Acme\UserBundle\DependencyInjection\Security\Factory\FacebookFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

class BundlesDefaultBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new FacebookFactory());

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/Resources/config'));
        $loader->load('assets.yml');
    }
}
