<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete\Model;

use AllyMailer\Client\Data;

/**
 * ObsoleteUnsubscribedListResponseUnsubscribedItem
 */
final class ObsoleteUnsubscribedListResponseUnsubscribedItem implements \JsonSerializable
{
    /**
     * Відписаний email.
     *
     * @var string|null
     */
    private $address;

    /**
     * Дата й час відписки адреси у форматі РРРР-ММ-ДД гг:хх:сс у часовому поясі UTC.
     * Приклад: `2020-10-15 22:14:59`.
     *
     * @var string|null
     */
    private $unsubscribedOn;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->address = Data::string($data['address'] ?? null);
        $model->unsubscribedOn = Data::string($data['unsubscribed_on'] ?? null);

        return $model;
    }

    /**
     * Відписаний email.
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Відписаний email.
     *
     * @return $this
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Дата й час відписки адреси у форматі РРРР-ММ-ДД гг:хх:сс у часовому поясі UTC.
     */
    public function getUnsubscribedOn(): ?string
    {
        return $this->unsubscribedOn;
    }

    /**
     * Дата й час відписки адреси у форматі РРРР-ММ-ДД гг:хх:сс у часовому поясі UTC.
     *
     * @return $this
     */
    public function setUnsubscribedOn(?string $unsubscribedOn): self
    {
        $this->unsubscribedOn = $unsubscribedOn;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'address' => $this->address,
            'unsubscribed_on' => $this->unsubscribedOn,
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
