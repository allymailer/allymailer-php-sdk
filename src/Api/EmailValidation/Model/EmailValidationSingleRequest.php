<?php

declare(strict_types=1);

namespace AllyMailer\Api\EmailValidation\Model;

use AllyMailer\Client\Data;

/**
 * EmailValidationSingleRequest
 */
final class EmailValidationSingleRequest implements \JsonSerializable
{
    /**
     * Email-адреса, яку необхідно перевірити.
     * Приклад: `email@example.com`.
     *
     * @var string
     */
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(Data::string($data['email'] ?? null) ?? '');
    }

    /**
     * Email-адреса, яку необхідно перевірити.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Email-адреса, яку необхідно перевірити.
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
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
