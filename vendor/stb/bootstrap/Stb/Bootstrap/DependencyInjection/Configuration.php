<?php

namespace Stb\Bootstrap\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('stb_bootstrap');
//        $rootNode->children()
//            ->arrayNode('extension_library')
//                ->addDefaultsIfNotSet()
//                ->children()
//                    ->scalarNode('bootstrap')->defaultTrue()->end()
//                    ->scalarNode('fancybox')->defaultTrue()->end()
//                    ->scalarNode('alertify')->defaultTrue()->end()
//                ->end()
//            ->end();


        return $treeBuilder;
    }
}
