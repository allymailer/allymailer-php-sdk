<?php

declare(strict_types=1);

namespace AllyMailer\Api\ConfirmedEmail\Model;

use AllyMailer\Client\Data;

/**
 * ConfirmedEmailCreateResponse
 */
final class ConfirmedEmailCreateResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * @var ConfirmedEmail|null
     */
    private $confirmedEmail;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->confirmedEmail = Data::model(ConfirmedEmail::class, $data['confirmed_email'] ?? null);

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

    public function getConfirmedEmail(): ?ConfirmedEmail
    {
        return $this->confirmedEmail;
    }

    /**
     * @return $this
     */
    public function setConfirmedEmail(?ConfirmedEmail $confirmedEmail): self
    {
        $this->confirmedEmail = $confirmedEmail;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'confirmed_email' => null === $this->confirmedEmail ? null : Data::object($this->confirmedEmail->toArray()),
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
