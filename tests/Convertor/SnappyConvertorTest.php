<?php

declare(strict_types=1);

namespace Toraido\Fatura\Test\Convertor;

use Knp\Snappy\Pdf;
use Toraido\Fatura\Convertor\SnappyConvertor;
use PHPUnit\Framework\TestCase;

final class SnappyConvertorTest extends TestCase
{
    public function testThatMarginIsFixedInConstructor(): void
    {
        $snappy = $this->createMock(Pdf::class);
        $snappy
            ->expects(self::exactly(4))
            ->method('setOption')
            ->withConsecutive(
                ['margin-bottom', 0],
                ['margin-top', 0],
                ['margin-left', 0],
                ['margin-right', 0],
            );

        new SnappyConvertor($snappy);
    }

    public function testConvert(): void
    {
        $snappy = $this->createMock(Pdf::class);
        $convertor = new SnappyConvertor($snappy);

        $snappy->expects(self::once())
            ->method('getOutputFromHtml')
            ->with('html')
            ->willReturn('pdf');

        $content = $convertor->convert('html');

        self::assertSame('pdf', $content);
    }
}
