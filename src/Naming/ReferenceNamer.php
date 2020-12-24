<?php

declare(strict_types=1);

namespace Toraido\Fatura\Naming;

use Psl\Str;
use Toraido\Fatura\Model\Invoice;

/**
 * @psalm-immutable
 */
final class ReferenceNamer implements Namer
{
    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function name(Invoice $invoice): string
    {
        /** @psalm-var non-empty-string */
        return Str\format('invoice-%s.pdf', $invoice->getReference());
    }
}
