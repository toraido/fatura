<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model;

use Psl;
use Psl\Math;

/**
 * @psalm-immutable
 */
final class Percentage
{
    /**
     * @psalm-pure
     */
    private function __construct(
        private int $rate,
        private bool $ciel
    ) {
    }

    /**
     * @param bool $ciel - whether to ciel or floor the result of applying this percentage
     *
     * @psalm-pure
     */
    public static function create(int $rate, bool $ciel = true): Percentage
    {
        Psl\invariant($rate >= 0 && $rate <= 100, 'Rate must be an integer between 0 and 100.');

        return new self($rate, $ciel);
    }

    /**
     * @psalm-mutation-free
     */
    public function of(Amount $amount): Amount
    {
        $value = $amount->getValue();
        if ($value === 0) {
            return Amount::create(0);
        }

        $value = (float) $value;
        $rate = (float) $this->rate;
        $value = ($rate / 100.0) * $value;
        if ($this->ciel) {
            $value = Math\ceil($value);
        } else {
            $value = Math\floor($value);
        }

        return Amount::create((int) $value);
    }

    /**
     * @psalm-mutation-free
     */
    public function getRate(): int
    {
        return $this->rate;
    }

    /**
     * @psalm-mutation-free
     */
    public function isCiel(): bool
    {
        return $this->ciel;
    }
}
