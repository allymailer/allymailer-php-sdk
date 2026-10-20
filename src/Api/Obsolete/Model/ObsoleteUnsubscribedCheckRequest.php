<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete\Model;

use AllyMailer\Client\Data;

/**
 * ObsoleteUnsubscribedCheckRequest
 */
final class ObsoleteUnsubscribedCheckRequest implements \JsonSerializable
{
    /**
     * Email, який необхідно перевірити.
     * Приклад: `email@example.com`.
     *
     * @var string
     */
    private $address;

    public function __construct(string $address)
    {
        $this->address = $address;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(Data::string($data['address'] ?? null) ?? '');
    }

    /**
     * Email, який необхідно перевірити.
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Email, який необхідно перевірити.
     *
     * @return $this
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'address' => $this->address,
        ], static function ($value): bool {
            return $value !== null;
        });
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return Data::object($this->toArray());
    }
}
