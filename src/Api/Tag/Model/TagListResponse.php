<?php

declare(strict_types=1);

namespace AllyMailer\Api\Tag\Model;

use AllyMailer\Client\Data;

/**
 * TagListResponse
 */
final class TagListResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Масив об'єктів з даними користувацьких міток.
         * @var list<TagsResponseObject>|null
         */
        public ?array $tags = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            tags: Data::list($data['tags'] ?? null, static fn ($item) => TagsResponseObject::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'tags' => null === $this->tags ? null : \array_map(static fn (TagsResponseObject $item) => Data::object($item->toArray()), $this->tags),
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
