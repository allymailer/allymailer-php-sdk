<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

use AllyMailer\Client\Data;

/**
 * DomainListRequest
 */
final class DomainListRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Опціональне ім'я домену, якщо вам потрібно отримати статуси лише за одним доменом.
         * Приклад: `example.com`.
         */
        public ?string $domain = null,
        /**
         * Максимальна кількість доменів, що повертаються. За замовчуванням 50.
         * За замовчуванням: `50`.
         */
        public ?int $limit = null,
        /**
         * Індекс першого домену зі списку, що повертається, рахуючи з нуля.
         * За замовчуванням: `0`.
         */
        public ?int $offset = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            domain: Data::string($data['domain'] ?? null),
            limit: Data::int($data['limit'] ?? null),
            offset: Data::int($data['offset'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'domain' => $this->domain,
            'limit' => $this->limit,
            'offset' => $this->offset,
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
