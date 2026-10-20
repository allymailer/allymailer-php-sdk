<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete\Model;

use AllyMailer\Client\Data;

/**
 * ObsoleteUnsubscribedSetResponse
 */
final class ObsoleteUnsubscribedSetResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Відписаний email.
         */
        public ?string $address = null,
        /**
         * Подробиці відписки:
         *
         * - "unsubscribed" якщо email було щойно відписано,
         * - "was inactive" якщо він уже був позначений як неактивний і немає сенсу відписувати,
         * - "was unsubscribed" якщо email уже було відписано раніше,
         * - "added and unsubscribed" якщо для цього email не зберігалося жодного більш раннього статусу, тому його було додано й одразу ж відписано.
         */
        public ObsoleteUnsubscribedSetMessage|string|null $message = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            address: Data::string($data['address'] ?? null),
            message: Data::enum(ObsoleteUnsubscribedSetMessage::class, Data::string($data['message'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'address' => $this->address,
            'message' => Data::value($this->message),
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
