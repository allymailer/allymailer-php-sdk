<?php

declare(strict_types=1);

namespace AllyMailer\Api\Tag\Model;

use AllyMailer\Client\Data;

/**
 * TagDeleteRequest
 */
final class TagDeleteRequest implements \JsonSerializable
{
    /**
     * Унікальний id мітки.
     * Приклад: `54`.
     *
     * @var int
     */
    private $tagId;

    public function __construct(int $tagId)
    {
        $this->tagId = $tagId;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(Data::int($data['tag_id'] ?? null) ?? 0);
    }

    /**
     * Унікальний id мітки.
     */
    public function getTagId(): int
    {
        return $this->tagId;
    }

    /**
     * Унікальний id мітки.
     *
     * @return $this
     */
    public function setTagId(int $tagId): self
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'tag_id' => $this->tagId,
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
