<?php

declare(strict_types=1);

namespace Toraido\Fatura\Twig;

use Toraido\Fatura\Formatter\Formatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class FormatterExtension extends AbstractExtension
{
    public function __construct(
        private Formatter $formatter,
    ) {
    }

    /**
     * @return list<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('fatura_format', [$this->formatter, 'format']),
        ];
    }
}
