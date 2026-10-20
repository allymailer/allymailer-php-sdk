<?php

declare(strict_types=1);

namespace AllyMailer\Api\ConfirmedEmail\Model;

use AllyMailer\Client\Data;

/**
 * ConfirmedEmailListResponse
 */
final class ConfirmedEmailListResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * @var list<ConfirmedEmail>|null
     */
    private $confirmedEmails;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->confirmedEmails = Data::list($data['confirmed_emails'] ?? null, static function ($item) { return ConfirmedEmail::fromArray(Data::array($item) ?? []); });

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
     * @return list<ConfirmedEmail>|null
     */
    public function getConfirmedEmails(): ?array
    {
        return $this->confirmedEmails;
    }

    /**
     * @param list<ConfirmedEmail>|null $confirmedEmails
     *
     * @return $this
     */
    public function setConfirmedEmails(?array $confirmedEmails): self
    {
        $this->confirmedEmails = $confirmedEmails;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'confirmed_emails' => null === $this->confirmedEmails ? null : \array_map(static function (ConfirmedEmail $item) { return Data::object($item->toArray()); }, $this->confirmedEmails),
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
