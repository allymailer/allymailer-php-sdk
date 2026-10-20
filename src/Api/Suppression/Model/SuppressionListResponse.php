<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * SuppressionListResponse
 */
final class SuppressionListResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Масив об'єктів з інформацією про недоступність.
     *
     * @var list<SuppressionListObject>|null
     */
    private $suppressions;

    /**
     * Параметр указує, з якої позиції починати вибірку. Має бути порожнім або відсутнім для отримання першої порції
     * даних; для отримання другої та наступних порцій його необхідно задавати, підставляючи значення поля "cursor" з
     * попередньої порції.
     * Приклад: `Ajfb6Hvdkn3hdhhvG57xbdufhG5`.
     *
     * @var string|null
     */
    private $cursor;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->suppressions = Data::list($data['suppressions'] ?? null, static function ($item) { return SuppressionListObject::fromArray(Data::array($item) ?? []); });
        $model->cursor = Data::string($data['cursor'] ?? null);

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
     * Масив об'єктів з інформацією про недоступність.
     *
     * @return list<SuppressionListObject>|null
     */
    public function getSuppressions(): ?array
    {
        return $this->suppressions;
    }

    /**
     * Масив об'єктів з інформацією про недоступність.
     *
     * @param list<SuppressionListObject>|null $suppressions
     *
     * @return $this
     */
    public function setSuppressions(?array $suppressions): self
    {
        $this->suppressions = $suppressions;

        return $this;
    }

    /**
     * Параметр указує, з якої позиції починати вибірку.
     */
    public function getCursor(): ?string
    {
        return $this->cursor;
    }

    /**
     * Параметр указує, з якої позиції починати вибірку.
     *
     * @return $this
     */
    public function setCursor(?string $cursor): self
    {
        $this->cursor = $cursor;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'suppressions' => null === $this->suppressions ? null : \array_map(static function (SuppressionListObject $item) { return Data::object($item->toArray()); }, $this->suppressions),
            'cursor' => $this->cursor,
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
