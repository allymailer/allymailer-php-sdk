<?php

declare(strict_types=1);

namespace AllyMailer\Api\Email\Model;

use AllyMailer\Client\Data;

/**
 * EmailSubscribeRequest
 */
final class EmailSubscribeRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Адреса відправника на підтвердженому домені. (Також підтримується іменування поля як "email_address_from").
         * Приклад: `email@example.com`.
         */
        public string $fromEmail,
        /**
         * Ім'я відправника. (Також підтримується іменування поля як "name_from").
         * Приклад: `Example`.
         */
        public string $fromName,
        /**
         * Адреса отримувача. (Також підтримується іменування поля як "email_address_to").
         * Приклад: `email@example.com`.
         */
        public string $toEmail,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            fromEmail: Data::string($data['from_email'] ?? null) ?? '',
            fromName: Data::string($data['from_name'] ?? null) ?? '',
            toEmail: Data::string($data['to_email'] ?? null) ?? '',
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'from_email' => $this->fromEmail,
            'from_name' => $this->fromName,
            'to_email' => $this->toEmail,
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
