<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * SuppressionListResponse
 */
final class SuppressionListResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Масив об'єктів з інформацією про недоступність.
         * @var list<SuppressionListObject>|null
         */
        public ?array $suppressions = null,
        /**
         * Параметр указує, з якої позиції починати вибірку. Має бути порожнім або відсутнім для отримання першої порції
         * даних; для отримання другої та наступних порцій його необхідно задавати, підставляючи значення поля "cursor" з
         * попередньої порції.
         * Приклад: `Ajfb6Hvdkn3hdhhvG57xbdufhG5`.
         */
        public ?string $cursor = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            suppressions: Data::list($data['suppressions'] ?? null, static fn ($item) => SuppressionListObject::fromArray(Data::array($item) ?? [])),
            cursor: Data::string($data['cursor'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'suppressions' => null === $this->suppressions ? null : \array_map(static fn (SuppressionListObject $item) => Data::object($item->toArray()), $this->suppressions),
            'cursor' => $this->cursor,
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
