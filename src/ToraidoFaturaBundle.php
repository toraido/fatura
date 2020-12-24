<?php

declare(strict_types=1);

namespace Toraido\Fatura;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Toraido\Fatura\DependencyInjection\FaturaExtension;

final class ToraidoFaturaBundle extends Bundle
{
    /**
     * @var ExtensionInterface|null
     */
    protected $extension = null;

    public function getNamespace(): string
    {
        return __NAMESPACE__;
    }

    public function getContainerExtension(): ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new FaturaExtension();
        }

        return $this->extension;
    }
}
