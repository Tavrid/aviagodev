<?php
namespace Stb\Bootstrap\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

use Stb\Bootstrap\ColumnTypes;

class ColumnTypesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach(ColumnTypes::$columnTypes as $name => $class){
            $container->register($name,$class)
                ->addArgument(new Reference('service_container'));
        }
    }
}
