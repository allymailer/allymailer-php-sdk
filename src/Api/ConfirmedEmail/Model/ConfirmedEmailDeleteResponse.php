<?php

declare(strict_types=1);

namespace AllyMailer\Api\ConfirmedEmail\Model;

use AllyMailer\Client\Data;

/**
 * ConfirmedEmailDeleteResponse
 */
final class ConfirmedEmailDeleteResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Приклад: `Confirmed email deleted`.
         */
        public ?string $message = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            message: Data::string($data['message'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'message' => $this->message,
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
