<?php

declare(strict_types=1);

namespace AllyMailer\Api\Tag\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт із властивостями користувацьких міток.
 */
final class TagsResponseObject implements \JsonSerializable
{
    /**
     * Унікальний id мітки.
     * Приклад: `54`.
     *
     * @var int|null
     */
    private $tagId;

    /**
     * Назва мітки.
     * Приклад: `example-tag1`.
     *
     * @var string|null
     */
    private $tag;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->tagId = Data::int($data['tag_id'] ?? null);
        $model->tag = Data::string($data['tag'] ?? null);

        return $model;
    }

    /**
     * Унікальний id мітки.
     */
    public function getTagId(): ?int
    {
        return $this->tagId;
    }

    /**
     * Унікальний id мітки.
     *
     * @return $this
     */
    public function setTagId(?int $tagId): self
    {
        $this->tagId = $tagId;

        return $this;
    }

    /**
     * Назва мітки.
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * Назва мітки.
     *
     * @return $this
     */
    public function setTag(?string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'tag_id' => $this->tagId,
            'tag' => $this->tag,
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
