<?php

declare(strict_types=1);

namespace Toraido\Fatura\Test;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Toraido\Fatura\Convertor\Convertor;
use Toraido\Fatura\Fatura;
use Toraido\Fatura\Model;
use Toraido\Fatura\Naming\Namer;
use Twig\Environment;

final class FaturaTest extends TestCase
{
    public function testRender(): void
    {
        $invoice = Model\Invoice::create(
            '000001',
            Model\Business::create(
                'Foo',
                '12345678',
                Model\Address::create('xxxxxxx', 'xxxxx', 'xxxx xxxxx xxxxxx', 'xxxx'),
            ),
            Model\Customer::create(
                'Bar',
                '12345678',
                Model\Address::create('xxxxxxx', 'xxxxx', 'xxxx xxxxx xxxxxx', 'xxxx'),
            ),
            Model\Currency::create('EUR'),
            Model\IssueDate::create(new DateTimeImmutable(), 14),
        );

        $environment = $this->createMock(Environment::class);
        $convertor = $this->createMock(Convertor::class);
        $namer = $this->createMock(Namer::class);

        $environment->expects(self::once())
            ->method('render')
            ->with('@ToraidoFatura/display.html.twig', [
                'invoice' => $invoice
            ])
            ->willReturn('html')
        ;

        $fatura = new Fatura($environment, $convertor, $namer);

        $html = $fatura->render($invoice);

        self::assertSame('html', $html);
    }

    public function testConvert(): void
    {
        $invoice = Model\Invoice::create(
            '000001',
            Model\Business::create(
                'Foo',
                '12345678',
                Model\Address::create('xxxxxxx', 'xxxxx', 'xxxx xxxxx xxxxxx', 'xxxx'),
            ),
            Model\Customer::create(
                'Bar',
                '12345678',
                Model\Address::create('xxxxxxx', 'xxxxx', 'xxxx xxxxx xxxxxx', 'xxxx'),
            ),
            Model\Currency::create('EUR'),
            Model\IssueDate::create(new DateTimeImmutable(), 14),
        );

        $environment = $this->createMock(Environment::class);
        $convertor = $this->createMock(Convertor::class);
        $namer = $this->createMock(Namer::class);

        $environment->expects(self::once())
            ->method('render')
            ->with('@ToraidoFatura/display.html.twig', [
                'invoice' => $invoice
            ])
            ->willReturn('html')
        ;

        $convertor->expects(self::once())
            ->method('convert')
            ->with('html')
            ->willReturn('pdf');

        $fatura = new Fatura($environment, $convertor, $namer);

        $pdf = $fatura->convert($invoice);

        self::assertSame('pdf', $pdf);
    }

    public function testDownload(): void
    {
        $invoice = Model\Invoice::create(
            '000001',
            Model\Business::create(
                'Foo',
                '12345678',
                Model\Address::create('xxxxxxx', 'xxxxx', 'xxxx xxxxx xxxxxx', 'xxxx'),
            ),
            Model\Customer::create(
                'Bar',
                '12345678',
                Model\Address::create('xxxxxxx', 'xxxxx', 'xxxx xxxxx xxxxxx', 'xxxx'),
            ),
            Model\Currency::create('EUR'),
            Model\IssueDate::create(new DateTimeImmutable(), 14),
        );

        $environment = $this->createMock(Environment::class);
        $convertor = $this->createMock(Convertor::class);
        $namer = $this->createMock(Namer::class);

        $environment->expects(self::once())
            ->method('render')
            ->with('@ToraidoFatura/display.html.twig', [
                'invoice' => $invoice
            ])
            ->willReturn('html')
        ;

        $convertor->expects(self::once())
            ->method('convert')
            ->with('html')
            ->willReturn('pdf');

        $namer->expects(self::once())
            ->method('name')
            ->with($invoice)
            ->willReturn('invoice.pdf');

        $fatura = new Fatura($environment, $convertor, $namer);

        $response = $fatura->download($invoice);

        self::assertSame('pdf', $response->getContent());
        self::assertSame('attachment; filename=invoice.pdf', $response->headers->get('Content-Disposition'));
    }
}
