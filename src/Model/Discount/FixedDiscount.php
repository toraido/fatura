<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model\Discount;

use Toraido\Fatura\Model\Amount;

/**
 * @psalm-immutable
 */
final class FixedDiscount implements Discount
{
    /**
     * @param non-empty-string $description
     *
     * @psalm-pure
     */
    private function __construct(
        private string $description,
        private Amount $amount
    ) {
    }

    /**
     * @param non-empty-string $description
     *
     * @psalm-pure
     */
    public static function create(string $description, Amount $amount): FixedDiscount
    {
        return new self($description, $amount);
    }

    /**
     * {@inheritDoc}
     *
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-mutation-free
     */
    public function getAmount(Amount $amount): Amount
    {
        return $this->amount;
    }
}
