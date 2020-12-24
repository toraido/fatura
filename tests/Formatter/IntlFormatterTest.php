<?php

declare(strict_types=1);

namespace Toraido\Fatura\Test\Formatter;

use Generator;
use Toraido\Fatura\Formatter\IntlFormatter;
use PHPUnit\Framework\TestCase;
use Toraido\Fatura\Model\Amount;
use Toraido\Fatura\Model\Currency;

final class IntlFormatterTest extends TestCase
{
    /**
     * @dataProvider provideFormatData
     */
    public function testFormat(string $locale, string $expected, Amount $amount, Currency $currency): void
    {
        $formatter = new IntlFormatter($locale);

        self::assertSame($expected, $formatter->format($amount, $currency));
    }

    /**
     * @return Generator<int, array{0: string, 1: string, 2: Amount, 3: Currency}, void, mixed>
     */
    public function provideFormatData(): Generator
    {
        yield ['EN', '$100.00', Amount::create(100_00), Currency::create('USD')];
        yield ['EN', '€100.00', Amount::create(100_00), Currency::create('EUR')];
        yield ['EN', 'TND 100.000', Amount::create(100_000), Currency::create('TND')];

        yield ['FR', '100,00 $US', Amount::create(100_00), Currency::create('USD')];
        yield ['FR', '100,00 €', Amount::create(100_00), Currency::create('EUR')];
        yield ['FR', '100,000 TND', Amount::create(100_000), Currency::create('TND')];

        yield ['AR_TN', 'US$ 100,00', Amount::create(100_00), Currency::create('USD')];
        yield ['AR_TN', '€ 100,00', Amount::create(100_00), Currency::create('EUR')];
        yield ['AR_TN', 'د.ت.‏ 100,000', Amount::create(100_000), Currency::create('TND')];

        yield ['AR', '١٠٠٫٠٠ US$', Amount::create(100_00), Currency::create('USD')];
        yield ['AR', '١٠٠٫٠٠ €', Amount::create(100_00), Currency::create('EUR')];
        yield ['AR', '١٠٠٫٠٠٠ د.ت.‏', Amount::create(100_000), Currency::create('TND')];
    }
}
