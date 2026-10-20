<?php

declare(strict_types=1);

namespace AllyMailer\Api\System\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт з властивостями періоду обліку. Присутній лише якщо API-ключ, використаний для запиту, був API-ключем
 * користувача.
 */
final class SystemInfoResponseAccounting implements \JsonSerializable
{
    public function __construct(
        /**
         * Дата й час початку періоду обліку в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
         * Приклад: `2016-08-29 09:12:33`.
         */
        public ?string $periodStart = null,
        /**
         * Дата й час кінця періоду обліку в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
         * Приклад: `2016-09-29 09:12:33`.
         */
        public ?string $periodEnd = null,
        /**
         * Кількість листів, включених в обліковий період.
         */
        public ?int $emailsIncluded = null,
        /**
         * Кількість листів, надісланих за обліковий період. Може бути більшою за emails_included у разі перевищення.
         */
        public ?int $emailsSent = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            periodStart: Data::string($data['period_start'] ?? null),
            periodEnd: Data::string($data['period_end'] ?? null),
            emailsIncluded: Data::int($data['emails_included'] ?? null),
            emailsSent: Data::int($data['emails_sent'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'period_start' => $this->periodStart,
            'period_end' => $this->periodEnd,
            'emails_included' => $this->emailsIncluded,
            'emails_sent' => $this->emailsSent,
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
