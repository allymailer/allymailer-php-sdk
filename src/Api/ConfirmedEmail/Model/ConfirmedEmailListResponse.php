<?php

declare(strict_types=1);

namespace AllyMailer\Api\ConfirmedEmail\Model;

use AllyMailer\Client\Data;

/**
 * ConfirmedEmailListResponse
 */
final class ConfirmedEmailListResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * @var list<ConfirmedEmail>|null
         */
        public ?array $confirmedEmails = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            confirmedEmails: Data::list($data['confirmed_emails'] ?? null, static fn ($item) => ConfirmedEmail::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'confirmed_emails' => null === $this->confirmedEmails ? null : \array_map(static fn (ConfirmedEmail $item) => Data::object($item->toArray()), $this->confirmedEmails),
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
