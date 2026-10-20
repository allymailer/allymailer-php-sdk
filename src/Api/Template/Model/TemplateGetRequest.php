<?php

declare(strict_types=1);

namespace AllyMailer\Api\Template\Model;

use AllyMailer\Client\Data;

/**
 * TemplateGetRequest
 */
final class TemplateGetRequest implements \JsonSerializable
{
    /**
     * Ідентифікатор шаблону.
     * Приклад: `00000000-0000-0000-0000-000000000000`.
     *
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(Data::string($data['id'] ?? null) ?? '');
    }

    /**
     * Ідентифікатор шаблону.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Ідентифікатор шаблону.
     *
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
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
