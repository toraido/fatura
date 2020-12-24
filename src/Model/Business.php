<?php

declare(strict_types=1);

namespace Toraido\Fatura\Model;

final class Business
{
    /**
     * @param non-empty-string $name
     * @param non-empty-string $identifier
     *
     * @psalm-pure
     */
    private function __construct(
        private string $name,
        private string $identifier,
        private Address $address
    ) {
    }

    /**
     * @param non-empty-string $name
     * @param non-empty-string $identifier
     *
     * @psalm-pure
     */
    public static function create(string $name, string $identifier, Address $address): Business
    {
        return new self($name, $identifier, $address);
    }

    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return non-empty-string
     *
     * @psalm-mutation-free
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @psalm-mutation-free
     */
    public function getAddress(): Address
    {
        return $this->address;
    }
}
