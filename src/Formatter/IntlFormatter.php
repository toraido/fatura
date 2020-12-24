<?php

declare(strict_types=1);

namespace Toraido\Fatura\Formatter;

use Money\Currencies\ISOCurrencies;
use Money\Currency as MoneyCurrency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;
use Toraido\Fatura\Model\Amount;
use Toraido\Fatura\Model\Currency;

final class IntlFormatter implements Formatter
{
    public const DEFAULT_LOCALE = 'en';

    private IntlMoneyFormatter $formatter;

    public function __construct(string $locale = self::DEFAULT_LOCALE)
    {
        $this->formatter = new IntlMoneyFormatter(
            new NumberFormatter($locale, NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );
    }

    public function format(Amount $amount, Currency $currency): string
    {
        return $this->formatter->format(new Money($amount->getValue(), new MoneyCurrency($currency->getCode())));
    }
}
