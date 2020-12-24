<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model\Discount;

use Toraido\Fatura\Model\Amount;
use Toraido\Fatura\Model\Percentage;

/**
 * @psalm-immutable
 */
final class PercentageDiscount implements Discount
{
    /**
     * @param non-empty-string $description
     *
     * @psalm-pure
     */
    private function __construct(
        private string $description,
        private Percentage $percentage
    ) {
    }

    /**
     * @param non-empty-string $description
     *
     * @psalm-pure
     */
    public static function create(string $description, Percentage $percentage): PercentageDiscount
    {
        return new self($description, $percentage);
    }

    /**
     * {@inheritDoc}
     *
     * @psalm-mutation-free
     */
    public function getAmount(Amount $amount): Amount
    {
        return $this->percentage->of($amount);
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
}
