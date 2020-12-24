<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model;

use Psl;
use Psl\Str;

/**
 * @psalm-immutable
 */
final class Address
{
    /**
     * @param non-empty-string $country
     * @param non-empty-string $city
     * @param non-empty-string $street
     * @param non-empty-string $postal
     *
     * @psalm-pure
     */
    private function __construct(
        private string $country,
        private string $city,
        private string $street,
        private string $postal
    ) {
    }

    /**
     * @param non-empty-string $country
     * @param non-empty-string $city
     * @param non-empty-string $street
     * @param non-empty-string $postal
     *
     * @psalm-pure
     */
    public static function create(string $country, string $city, string $street, string $postal): Address
    {
        return new self($country, $city, $street, $postal);
    }

    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getPostal(): string
    {
        return $this->postal;
    }
}
