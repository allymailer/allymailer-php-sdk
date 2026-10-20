<?php

declare(strict_types=1);

namespace AllyMailer\Api\ConfirmedEmail\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\VerificationRecordStatus;

/**
 * ConfirmedEmail
 */
final class ConfirmedEmail implements \JsonSerializable
{
    public function __construct(
        /**
         * Приклад: `dev@example.com`.
         */
        public ?string $email = null,
        /**
         * Confirmation status of the email address.
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
            email: Data::string($data['email'] ?? null),
            status: Data::enum(VerificationRecordStatus::class, Data::string($data['status'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
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
