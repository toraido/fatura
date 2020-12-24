<?php

declare(strict_types=1);

namespace Toraido\Fatura\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Toraido\Fatura\Formatter\IntlFormatter;

final class FaturaExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('fatura.xml');

        $container->resolveEnvPlaceholders($config);
        $container->getDefinition(IntlFormatter::class)
            ->setArgument(0, $config['default_locale']);
    }

    /**
     * @return non-empty-string
     */
    public function getAlias(): string
    {
        return 'fatura';
    }
}
