<?php

declare(strict_types=1);

namespace Toraido\Fatura\Convertor;

use Psl;
use Knp\Snappy\Pdf as Snappy;

final class SnappyConvertor implements Convertor
{
    public function __construct(
        private Snappy $snappy
    ) {
        $this->snappy->setOption('margin-bottom', 0);
        $this->snappy->setOption('margin-top', 0);
        $this->snappy->setOption('margin-left', 0);
        $this->snappy->setOption('margin-right', 0);
    }

    /**
     * Convert the given HTML to PDF.
     *
     * @param non-empty-string $html
     *
     * @return non-empty-string PDF document content.
     */
    public function convert(string $html): string
    {
        $pdf = $this->snappy->getOutputFromHtml($html);

        Psl\invariant($pdf !== '', 'Internal: snappy returned an empty string.');

        return $pdf;
    }
}
