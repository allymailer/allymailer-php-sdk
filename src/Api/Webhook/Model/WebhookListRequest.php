<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * WebhookListRequest
 */
final class WebhookListRequest implements \JsonSerializable
{
    /**
     * Максимальна кількість webhook, що повертаються за один виклик. Рекомендується 50.
     *
     * @var int|null
     */
    private $limit;

    /**
     * Індекс першого webhook зі списку, що повертається, рахуючи з нуля.
     * За замовчуванням: `0`.
     *
     * @var int|null
     */
    private $offset;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->limit = Data::int($data['limit'] ?? null);
        $model->offset = Data::int($data['offset'] ?? null);

        return $model;
    }

    /**
     * Максимальна кількість webhook, що повертаються за один виклик.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Максимальна кількість webhook, що повертаються за один виклик.
     *
     * @return $this
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Індекс першого webhook зі списку, що повертається, рахуючи з нуля.
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * Індекс першого webhook зі списку, що повертається, рахуючи з нуля.
     *
     * @return $this
     */
    public function setOffset(?int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'limit' => $this->limit,
            'offset' => $this->offset,
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
