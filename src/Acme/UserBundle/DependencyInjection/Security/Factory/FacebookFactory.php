<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.03.14
 * Time: 20:50
 */

namespace Acme\UserBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class FacebookFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $providerId = 'security.authentication.provider.facebook.'.$id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('facebook.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider));
//            ->replaceArgument(1, $config['lifetime']);
        $listenerId = 'security.authentication.listener.facebook.'.$id;
        $listener = $container->setDefinition($listenerId, new DefinitionDecorator('facebook.security.authentication.listener'));

        return array($providerId, $listenerId, $defaultEntryPoint);
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'facebook';
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
            ->scalarNode('lifetime')->defaultValue(300)
            ->end();
    }


}