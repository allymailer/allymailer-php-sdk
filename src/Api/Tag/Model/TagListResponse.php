<?php

declare(strict_types=1);

namespace AllyMailer\Api\Tag\Model;

use AllyMailer\Client\Data;

/**
 * TagListResponse
 */
final class TagListResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Масив об'єктів з даними користувацьких міток.
     *
     * @var list<TagsResponseObject>|null
     */
    private $tags;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->tags = Data::list($data['tags'] ?? null, static function ($item) { return TagsResponseObject::fromArray(Data::array($item) ?? []); });

        return $model;
    }

    /**
     * Рядок "success".
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Рядок "success".
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Масив об'єктів з даними користувацьких міток.
     *
     * @return list<TagsResponseObject>|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * Масив об'єктів з даними користувацьких міток.
     *
     * @param list<TagsResponseObject>|null $tags
     *
     * @return $this
     */
    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'tags' => null === $this->tags ? null : \array_map(static function (TagsResponseObject $item) { return Data::object($item->toArray()); }, $this->tags),
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
