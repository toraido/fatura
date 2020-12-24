<?php

declare(strict_types=1);

namespace Toraido\Fatura\Test\Naming;

use DateTimeImmutable;
use Generator;
use PHPUnit\Framework\TestCase;
use Toraido\Fatura\Model;
use Toraido\Fatura\Naming\ReferenceNamer;

final class ReferenceNamerTest extends TestCase
{
    /**
     * @dataProvider provideNameData
     */
    public function testName(string $expected, Model\Invoice $invoice): void
    {
        $namer = new ReferenceNamer();

        self::assertSame($expected, $namer->name($invoice));
    }

    /**
     * @return Generator<int, array{0: string, 1: Model\Invoice}, void, mixed>
     */
    public function provideNameData(): Generator
    {
        $invoice =
            /**
             * @param non-empty-string $reference
             */
            static function (string $reference): Model\Invoice {
                $business = Model\Business::create(
                    'Foo',
                    '12345678',
                    Model\Address::create('xxxxxxx', 'xxxxx', 'xxxx xxxxx xxxxxx', 'xxxx'),
                );

                $customer = Model\Customer::create(
                    'Bar',
                    '12345678',
                    Model\Address::create('xxxxxxx', 'xxxxx', 'xxxx xxxxx xxxxxx', 'xxxx'),
                );

                return Model\Invoice::create(
                    $reference,
                    $business,
                    $customer,
                    Model\Currency::create('EUR'),
                    Model\IssueDate::create(new DateTimeImmutable(), 14),
                );
            };

        yield ['invoice-00004.pdf', $invoice('00004')];
        yield ['invoice-1.pdf', $invoice('1')];
        yield ['invoice-#123.pdf', $invoice('#123')];
    }
}
