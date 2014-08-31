<?php

namespace Acme\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Acme\BootstrapBundle\DependencyInjection\Compiler\ColumnTypesPass;

class AcmeCoreBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
