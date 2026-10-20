<?php

declare(strict_types=1);

namespace AllyMailer\Api\Template\Model;

use AllyMailer\Client\Data;

/**
 * TemplateListRequest
 */
final class TemplateListRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Максимальна кількість шаблонів, що повертаються, за замовчуванням 50.
         * За замовчуванням: `50`.
         */
        public ?int $limit = null,
        /**
         * Індекс першого шаблону зі списку, що повертається, рахуючи з нуля.
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
