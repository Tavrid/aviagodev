<?php

namespace Acme\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

class AcmeAdminBundle extends Bundle {
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
