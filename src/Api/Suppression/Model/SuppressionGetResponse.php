<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * SuppressionGetResponse
 */
final class SuppressionGetResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Email-адреса, для якої було запитано дані про недоступність.
         */
        public ?string $email = null,
        /**
         * Масив об'єктів з інформацією про недоступність.
         * @var list<SuppressionGetObject>|null
         */
        public ?array $suppressions = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            email: Data::string($data['email'] ?? null),
            suppressions: Data::list($data['suppressions'] ?? null, static fn ($item) => SuppressionGetObject::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'email' => $this->email,
            'suppressions' => null === $this->suppressions ? null : \array_map(static fn (SuppressionGetObject $item) => Data::object($item->toArray()), $this->suppressions),
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
