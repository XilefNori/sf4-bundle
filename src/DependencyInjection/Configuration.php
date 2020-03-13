<?php

namespace KnpU\LoremIpsumBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(KnpULoremIpsumExtension::ALIAS);
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->booleanNode('unicorns_are_real')->defaultTrue()->info('Make unicorns REAL!')->end()
                ->integerNode('min_sunshine')->defaultValue(3)->info('More sunshine make you happy!')->end()
            ->end()
        ;

        return $treeBuilder;
    }

}
