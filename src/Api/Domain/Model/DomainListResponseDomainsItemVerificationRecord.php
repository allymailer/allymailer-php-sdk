<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\VerificationRecordStatus;

/**
 * Об'єкт, що описує запис перевірки володіння та її статус.
 */
final class DomainListResponseDomainsItemVerificationRecord implements \JsonSerializable
{
    /**
     * Запис, який потрібно внести "як є" для підтвердження володіння цим доменом.
     * Приклад: `allymailer-validate-hash=483bb362ebdbeedd755cfb1d4d661`.
     *
     * @var string|null
     */
    private $value;

    /**
     * Лише домени зі статусом "confirmed" запису про володіння доменом можуть використовуватися для надсилання
     * листів.
     * Значення: константи `VerificationRecordStatus`.
     *
     * @var string|null
     */
    private $status;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->value = Data::string($data['value'] ?? null);
        $model->status = Data::string($data['status'] ?? null);

        return $model;
    }

    /**
     * Запис, який потрібно внести "як є" для підтвердження володіння цим доменом.
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Запис, який потрібно внести "як є" для підтвердження володіння цим доменом.
     *
     * @return $this
     */
    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Лише домени зі статусом "confirmed" запису про володіння доменом можуть використовуватися для надсилання
     * листів.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Лише домени зі статусом "confirmed" запису про володіння доменом можуть використовуватися для надсилання
     * листів.
     *
     * @param string|null $status Значення: константи `VerificationRecordStatus`.
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'value' => $this->value,
            'status' => $this->status,
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
