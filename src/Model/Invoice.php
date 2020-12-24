<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model;

use Toraido\Fatura\Model\Discount\Discount;
use Toraido\Fatura\Model\Tax\Tax;

/**
 * @psalm-immutable
 */
final class Invoice
{
    /**
     * @param non-empty-string $reference
     * @param list<Item> $items
     * @param list<Discount> $discounts
     * @param list<Tax> $taxes
     *
     * @psalm-pure
     */
    public function __construct(
        private string $reference,
        private Business $business,
        private Customer $customer,
        private Currency $currency,
        private IssueDate $issueDate,
        private array $items = [],
        private array $discounts = [],
        private array $taxes = [],
        private string $note = '',
        private bool $void = false
    ) {
    }

    /**
     * @param non-empty-string $reference
     * @param list<Item> $items
     * @param list<Discount> $discounts
     * @param list<Tax> $taxes
     *
     * @psalm-pure
     */
    public static function create(
        string $reference,
        Business $business,
        Customer $customer,
        Currency $currency,
        IssueDate $issueDate,
        array $items = [],
        array $discounts = [],
        array $taxes = [],
        string $note = '',
        bool $void = false,
    ): Invoice {
        return new self(
            $reference,
            $business,
            $customer,
            $currency,
            $issueDate,
            $items,
            $discounts,
            $taxes,
            $note,
            $void,
        );
    }

    /**
     * @psalm-mutation-free
     */
    public function withItem(Item $item): Invoice
    {
        $items = $this->getItems();
        $items[] = $item;

        return new self(
            $this->reference,
            $this->business,
            $this->customer,
            $this->currency,
            $this->issueDate,
            $items,
            $this->discounts,
            $this->taxes,
            $this->note,
            $this->void
        );
    }

    /**
     * @psalm-mutation-free
     */
    public function withDiscount(Discount $discount): Invoice
    {
        $discounts = $this->getDiscounts();
        $discounts[] = $discount;

        return new self(
            $this->reference,
            $this->business,
            $this->customer,
            $this->currency,
            $this->issueDate,
            $this->items,
            $discounts,
            $this->taxes,
            $this->note,
            $this->void
        );
    }

    /**
     * @psalm-mutation-free
     */
    public function withTax(Tax $tax): Invoice
    {
        $taxes = $this->getTaxes();
        $taxes [] = $tax;

        return new self(
            $this->reference,
            $this->business,
            $this->customer,
            $this->currency,
            $this->issueDate,
            $this->items,
            $this->discounts,
            $taxes,
            $this->note,
            $this->void
        );
    }

    /**
     * @psalm-mutation-free
     */
    public function withNote(string $note): Invoice
    {
        return new self(
            $this->reference,
            $this->business,
            $this->customer,
            $this->currency,
            $this->issueDate,
            $this->items,
            $this->discounts,
            $this->taxes,
            $note,
            $this->void
        );
    }

    /**
     * @psalm-mutation-free
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @psalm-mutation-free
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @psalm-mutation-free
     */
    public function getBusiness(): Business
    {
        return $this->business;
    }

    /**
     * @psalm-mutation-free
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @psalm-mutation-free
     */
    public function getIssueDate(): IssueDate
    {
        return $this->issueDate;
    }

    /**
     * @return list<Item>
     *
     * @psalm-mutation-free
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return list<Discount>
     *
     * @psalm-mutation-free
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    /**
     * @return list<Tax>
     *
     * @psalm-mutation-free
     */
    public function getTaxes(): array
    {
        return $this->taxes;
    }

    /**
     * @psalm-mutation-free
     */
    public function getNote(): string
    {
        return $this->note;
    }

    /**
     * @psalm-mutation-free
     */
    public function isVoid(): bool
    {
        return $this->void;
    }

    /**
     * @psalm-mutation-free
     */
    public function getSubtotal(): Amount
    {
        $subtotal = Amount::create(0);
        foreach ($this->getItems() as $item) {
            $subtotal = $subtotal->add($item->getUnitPrice()->multiply($item->getQuantity()));
        }

        return $subtotal;
    }

    /**
     * @psalm-mutation-free
     */
    public function getDiscountsTotal(): Amount
    {
        $discounts = Amount::create(0);
        $subtotal = $this->getSubtotal();
        foreach ($this->getDiscounts() as $discount) {
            $discounts = $discounts->add($discount->getAmount($subtotal));
        }

        return $discounts;
    }

    /**
     * @psalm-mutation-free
     */
    public function getSubtotalIncludingDiscounts(): Amount
    {
        return $this->getSubtotal()
            ->minus($this->getDiscountsTotal());
    }

    /**
     * @psalm-mutation-free
     */
    public function getTaxesTotal(): Amount
    {
        $taxes = Amount::create(0);
        $subtotal = $this->getSubtotalIncludingDiscounts();
        foreach ($this->getTaxes() as $tax) {
            $taxes = $taxes->add($tax->getAmount($subtotal));
        }

        return $taxes;
    }

    /**
     * @psalm-mutation-free
     */
    public function getTotal(): Amount
    {
        return $this->getSubtotal()
            ->minus($this->getDiscountsTotal())
            ->add($this->getTaxesTotal());
    }
}
