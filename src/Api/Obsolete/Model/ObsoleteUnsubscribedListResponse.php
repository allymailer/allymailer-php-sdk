<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete\Model;

use AllyMailer\Client\Data;

/**
 * ObsoleteUnsubscribedListResponse
 */
final class ObsoleteUnsubscribedListResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Масив об'єктів з даними відписаних.
     *
     * @var list<ObsoleteUnsubscribedListResponseUnsubscribedItem>|null
     */
    private $unsubscribed;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->unsubscribed = Data::list($data['unsubscribed'] ?? null, static function ($item) { return ObsoleteUnsubscribedListResponseUnsubscribedItem::fromArray(Data::array($item) ?? []); });

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
     * Масив об'єктів з даними відписаних.
     *
     * @return list<ObsoleteUnsubscribedListResponseUnsubscribedItem>|null
     */
    public function getUnsubscribed(): ?array
    {
        return $this->unsubscribed;
    }

    /**
     * Масив об'єктів з даними відписаних.
     *
     * @param list<ObsoleteUnsubscribedListResponseUnsubscribedItem>|null $unsubscribed
     *
     * @return $this
     */
    public function setUnsubscribed(?array $unsubscribed): self
    {
        $this->unsubscribed = $unsubscribed;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'unsubscribed' => null === $this->unsubscribed ? null : \array_map(static function (ObsoleteUnsubscribedListResponseUnsubscribedItem $item) { return Data::object($item->toArray()); }, $this->unsubscribed),
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
