# Fatura

Fatura is a Symfony bundle that helps you generate PDF invoices.

> Note: fatura does *not* persist invoices in the database

## Installation

Install using composer:

```shell
composer require toraido/fatura
```

> Fatura requires [KNPSnappyBundle](https://github.com/KnpLabs/KnpSnappyBundle) to be able to generate PDF files, and [TwigExtraBundle](https://github.com/twigphp/twig-extra-bundle) to inline css.

Then enable all required bundles in your kernel:

```php
// config/bundles.php

return [

    //...

    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    Knp\Bundle\SnappyBundle\KnpSnappyBundle::class => ['all' => true],
    Toraido\Fatura\ToraidoFaturaBundle::class => ['all', true],
];
```

## Configuration

Fatura has no configurations, however, you might need to configure
the [KNPSnappyBundle](https://github.com/KnpLabs/KnpSnappyBundle).

## Usage

```php
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;use Toraido\Fatura\Model;
use Toraido\Fatura\Fatura;
use DateTimeImmutable;

final class InvoiceController
{
    public function __construct(
        private Fatura $fatura
    ) {}

    /**
     * @Route("/invoice/download", methods={"GET"}, name="invoice_download") 
     */
    public function download(): Response
    {
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

        $invoice = Model\Invoice::create(
            '#000001',
            $business,
            $customer,
            Model\Currency::create('EUR'),
            Model\IssueDate::create(new DateTimeImmutable(), terms: 14),
        )

            ->withItem(Model\Item::create('Software Development', Model\Amount::create(20_000), quantity: 40))
            ->withItem(Model\Item::create('Logo Design', Model\Amount::create(2000_000)))

            ->withTax(Model\Tax\PercentageTax::create('Sales Taxes ( 19% )', Model\Percentage::create(19)))
        ;

        return $this->fatura->download($invoice);
    }
}
```

## License

The MIT License (MIT). Please see [LICENSE](./LICENSE) for more information.
