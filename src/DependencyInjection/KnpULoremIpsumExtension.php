<?php

namespace KnpU\LoremIpsumBundle\DependencyInjection;

use KnpU\LoremIpsumBundle\WordProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class KnpULoremIpsumExtension extends Extension
{
    public const ALIAS = 'knpu_lorem_ipsum';

    // ContainerBuilder - is a dummy empty container at the beginning of this method
    // Symfony then merges it into the REAL one
    public function load(array $configs, ContainerBuilder $container)
    {
        // var_dump($configs); exit;

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('knpu_lorem_ipsum.knpu_ipsum');

        $definition->setArgument(1, $config['unicorns_are_real']);
        $definition->setArgument(2, $config['min_sunshine']);

        $container->registerForAutoconfiguration(WordProviderInterface::class)
            ->addTag('knpu_ipsum_word_provider');

        // var_dump($config); exit;
    }

    public function getAlias()
    {
        return self::ALIAS;
    }
}
