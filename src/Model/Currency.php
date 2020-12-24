<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model;

use Psl;

/**
 * @psalm-immutable
 */
final class Currency
{
    /**
     * @param non-empty-string $code
     *
     * @psalm-pure
     */
    private function __construct(
        private string $code
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function create(string $code): Currency
    {
        Psl\invariant('' !== $code, 'Currency code should not be empty.');

        return new self($code);
    }

    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getCode(): string
    {

        return $this->code;
    }
}
