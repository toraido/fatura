<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model\Tax;

use Toraido\Fatura\Model\Amount;

/**
 * @psalm-immutable
 */
final class FixedTax implements Tax
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
    public static function create(string $description, Amount $amount): FixedTax
    {
        return new self($description, $amount);
    }

    /**
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
