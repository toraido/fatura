<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model;

use Psl;

/**
 * @psalm-immutable
 */
final class Amount
{
    /**
     * @psalm-pure
     */
    public function __construct(
        private int $value
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function create(int $value): Amount
    {
        return new self($value);
    }

    /**
     * @psalm-mutation-free
     */
    public function add(Amount $amount): Amount
    {
        return self::create($this->value + $amount->value);
    }

    /**
     * @psalm-mutation-free
     */
    public function minus(Amount $amount): Amount
    {
        return self::create($this->value - $amount->value);
    }

    /**
     * @psalm-mutation-free
     */
    public function multiply(int $quantity): Amount
    {
        Psl\invariant($quantity >= 0, 'Cannot use a negative quantity.');

        return self::create($this->value * $quantity);
    }

    /**
     * @psalm-mutation-free
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
