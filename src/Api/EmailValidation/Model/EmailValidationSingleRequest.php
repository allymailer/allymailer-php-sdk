<?php

declare(strict_types=1);

namespace AllyMailer\Api\EmailValidation\Model;

use AllyMailer\Client\Data;

/**
 * EmailValidationSingleRequest
 */
final class EmailValidationSingleRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Email-адреса, яку необхідно перевірити.
         * Приклад: `email@example.com`.
         */
        public string $email,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: Data::string($data['email'] ?? null) ?? '',
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    public function jsonSerialize(): mixed
    {
        return Data::object($this->toArray());
    }
}
