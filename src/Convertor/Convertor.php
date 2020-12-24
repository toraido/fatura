<?php

declare(strict_types=1);

namespace Toraido\Fatura\Convertor;

interface Convertor
{
    /**
     * Convert the given HTML to PDF.
     *
     * @param non-empty-string $html
     *
     * @return non-empty-string PDF document content.
     */
    public function convert(string $html): string;
}
