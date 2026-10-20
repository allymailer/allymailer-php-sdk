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
    public function __construct(
        /**
         * Запис, який потрібно внести "як є" для підтвердження володіння цим доменом.
         * Приклад: `allymailer-validate-hash=483bb362ebdbeedd755cfb1d4d661`.
         */
        public ?string $value = null,
        /**
         * Лише домени зі статусом "confirmed" запису про володіння доменом можуть використовуватися для надсилання
         * листів.
         */
        public VerificationRecordStatus|string|null $status = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            value: Data::string($data['value'] ?? null),
            status: Data::enum(VerificationRecordStatus::class, Data::string($data['status'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'value' => $this->value,
            'status' => Data::value($this->status),
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
