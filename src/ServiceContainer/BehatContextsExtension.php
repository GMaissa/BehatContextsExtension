<?php
/**
 * This file is part of the GMaissa Behat Context Extension
 *
 * @package   GMaissa\BehatContextsExtension
 * @author    Guillaume Maïssa <guillaume@maissa.fr>
 * @copyright 2017 Guillaume Maïssa
 * @license   https://opensource.org/licenses/MIT MIT
 */

namespace GMaissa\BehatContextsExtension\ServiceContainer;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension as ExtensionInterface;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Context Extension for Behat class.
 */
class BehatContextsExtension implements ExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigKey()
    {
        return 'gm';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        // Nothing to initialize
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        // Nothing to configure
    }

    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        // Nothing to process
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadClassResolver($container);
        $this->loadContextInitializer($container);
    }

    /**
     * Load Extension Context class resolver
     *
     * @param ContainerBuilder $container
     */
    private function loadClassResolver(ContainerBuilder $container)
    {
        $definition = new Definition('GMaissa\BehatContextsExtension\Context\Resolver\ContextResolver');
        $definition->addTag(ContextExtension::CLASS_RESOLVER_TAG);
        $container->setDefinition('gm.context.class_resolver', $definition);
    }

    /**
     * Load Extension Context Initializer class
     *
     * @param ContainerBuilder $container
     */
    private function loadContextInitializer(ContainerBuilder $container)
    {
        $definition = new Definition(
            'GMaissa\BehatContextsExtension\Context\Initializer\WithBehatchHttpRequestInitializer',
            array(
                new Reference('behatch.http_call.request'),
            )
        );
        $definition->addTag(ContextExtension::INITIALIZER_TAG, array('priority' => 0));
        $container->setDefinition('gm.context.initializer', $definition);
    }
}
