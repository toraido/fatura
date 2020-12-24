<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model\Discount;

use Toraido\Fatura\Model\Amount;

interface Discount
{
    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getDescription(): string;

    /**
     * Given the subtotal, get the discount amount.
     *
     * @psalm-mutation-free
     */
    public function getAmount(Amount $amount): Amount;
}
