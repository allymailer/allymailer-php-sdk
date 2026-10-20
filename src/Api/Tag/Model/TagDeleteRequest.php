<?php

declare(strict_types=1);

namespace AllyMailer\Api\Tag\Model;

use AllyMailer\Client\Data;

/**
 * TagDeleteRequest
 */
final class TagDeleteRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Унікальний id мітки.
         * Приклад: `54`.
         */
        public int $tagId,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            tagId: Data::int($data['tag_id'] ?? null) ?? 0,
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'tag_id' => $this->tagId,
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
