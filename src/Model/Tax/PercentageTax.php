<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model\Tax;

use Toraido\Fatura\Model\Amount;
use Toraido\Fatura\Model\Percentage;

/**
 * @psalm-immutable
 */
final class PercentageTax implements Tax
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
    public static function create(string $description, Percentage $percentage): PercentageTax
    {
        return new self($description, $percentage);
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
        return $this->percentage->of($amount);
    }
}
