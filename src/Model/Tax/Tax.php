<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model\Tax;

use Toraido\Fatura\Model\Amount;

interface Tax
{
    /**
     * Retrieve the name of this tax.
     *
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getDescription(): string;

    /**
     * Given the subtotal ( discounts included ), return the tax amount.
     *
     * @psalm-mutation-free
     */
    public function getAmount(Amount $amount): Amount;
}
