<?php

declare(strict_types=1);

namespace Toraido\Fatura\Naming;

use Toraido\Fatura\Model\Invoice;

interface Namer
{
    /**
     * Return the name of the invoice to use for downloading.
     *
     * @return non-empty-string The invoice file name, including the `.pdf` extension.
     *
     * @psalm-mutation-free
     */
    public function name(Invoice $invoice): string;
}
