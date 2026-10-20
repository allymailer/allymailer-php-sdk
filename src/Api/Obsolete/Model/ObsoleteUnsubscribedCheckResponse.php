<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete\Model;

use AllyMailer\Client\Data;

/**
 * ObsoleteUnsubscribedCheckResponse
 */
final class ObsoleteUnsubscribedCheckResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Email, який було перевірено.
     *
     * @var string|null
     */
    private $address;

    /**
     * true якщо відписано, false якщо ні.
     *
     * @var bool|null
     */
    private $isUnsubscribed;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->address = Data::string($data['address'] ?? null);
        $model->isUnsubscribed = Data::bool($data['is_unsubscribed'] ?? null);

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
     * Email, який було перевірено.
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Email, який було перевірено.
     *
     * @return $this
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * true якщо відписано, false якщо ні.
     */
    public function getIsUnsubscribed(): ?bool
    {
        return $this->isUnsubscribed;
    }

    /**
     * true якщо відписано, false якщо ні.
     *
     * @return $this
     */
    public function setIsUnsubscribed(?bool $isUnsubscribed): self
    {
        $this->isUnsubscribed = $isUnsubscribed;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'address' => $this->address,
            'is_unsubscribed' => $this->isUnsubscribed,
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
