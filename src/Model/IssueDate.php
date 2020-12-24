<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model;

use Psl\Str;
use DateTimeImmutable;

/**
 * @psalm-immutable
 */
final class IssueDate
{
    /**
     * @param positive-int $terms
     *
     * @psalm-pure
     */
    private function __construct(
        private DateTimeImmutable $date,
        private int $terms,
    ) {
    }

    /**
     * @param positive-int $terms
     *
     * @psalm-pure
     */
    public static function create(DateTimeImmutable $date, int $terms): IssueDate
    {
        return new self($date, $terms);
    }

    /**
     * @psalm-mutation-free
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return positive-int
     *
     * @psalm-mutation-free
     */
    public function getTerms(): int
    {
        return $this->terms;
    }

    /**
     * @psalm-mutation-free
     */
    public function getDueAt(): DateTimeImmutable
    {
        return $this->getDate()->modify(Str\format('+%d days', $this->getTerms()));
    }
}
