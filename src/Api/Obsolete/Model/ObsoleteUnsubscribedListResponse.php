<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete\Model;

use AllyMailer\Client\Data;

/**
 * ObsoleteUnsubscribedListResponse
 */
final class ObsoleteUnsubscribedListResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Масив об'єктів з даними відписаних.
         * @var list<ObsoleteUnsubscribedListResponseUnsubscribedItem>|null
         */
        public ?array $unsubscribed = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            unsubscribed: Data::list($data['unsubscribed'] ?? null, static fn ($item) => ObsoleteUnsubscribedListResponseUnsubscribedItem::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'unsubscribed' => null === $this->unsubscribed ? null : \array_map(static fn (ObsoleteUnsubscribedListResponseUnsubscribedItem $item) => Data::object($item->toArray()), $this->unsubscribed),
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
