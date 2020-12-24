<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model;

/**
 * @psalm-immutable
 */
final class Item
{
    /**
     * @param non-empty-string $description
     * @param positive-int $quantity
     *
     * @psalm-pure
     */
    public function __construct(
        private string $description,
        private Amount $unitPrice,
        private int $quantity,
    ) {
    }

    /**
     * @param non-empty-string $description
     * @param positive-int $quantity
     *
     * @psalm-pure
     */
    public static function create(string $description, Amount $unitPrice, int $quantity = 1): Item
    {
        return new self($description, $unitPrice, $quantity);
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
     * @psalm-mutation-free
     */
    public function getUnitPrice(): Amount
    {
        return $this->unitPrice;
    }

    /**
     * @return positive-int
     *
     * @psalm-mutation-free
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
