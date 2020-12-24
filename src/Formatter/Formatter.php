<?php

declare(strict_types=1);

namespace Toraido\Fatura\Formatter;

use Toraido\Fatura\Model\Amount;
use Toraido\Fatura\Model\Currency;

interface Formatter
{
    /**
     * Format the given amount in the given currency to be displayed.
     */
    public function format(Amount $amount, Currency $currency): string;
}
