<?php

declare(strict_types=1);

namespace Toraido\Fatura\DependencyInjection;

use Psl\Env;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Toraido\Fatura\Formatter\IntlFormatter;

final class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress PossiblyUndefinedMethod
     * @psalm-suppress MixedMethodCall
     *
     * @noinspection NullPointerExceptionInspection
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('fatura');
        $root = $builder->getRootNode();

        $root
            ->children()
                ->scalarNode('default_locale')
                    ->defaultValue(IntlFormatter::DEFAULT_LOCALE)
                ->end()
                ->scalarNode('temporary_directory')
                    ->defaultValue(Env\temp_dir())
                ->end()
                ->booleanNode('compress')
                    ->defaultTrue()
                ->end()
            ->end();

        return $builder;
    }
}
