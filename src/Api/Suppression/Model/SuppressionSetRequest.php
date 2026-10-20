<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * SuppressionSetRequest
 */
final class SuppressionSetRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Email-адреса, яку потрібно додати до списку недоступних.
         * Приклад: `email@example.com`.
         */
        public string $email,
        /**
         * Причина, з якої надсилання на цей email блокується. Одна з таких:
         *
         * - __unsubscribed__ - зазначену адресу відписано;
         * - __temporary_unavailable__ - адреса тимчасово недоступна. Це означає, що протягом наступних трьох діб надсилання на цю адресу повертатиме помилку. Email може бути тимчасово недоступним з різних причин, наприклад:
         *
         * - попереднє надсилання було відхилено сервером отримувача як спам;
         * - поштова скринька отримувача переповнена або не використовується;
         * - домен не приймає пошту через неправильне налаштування на боці отримувача або з інших причин;
         * - сервер відправника було відхилено через блеклистинг;
         *
         * - __permanent_unavailable__ - адреса перманентно недоступна через багаторазові недоставки;
         * - __complained__ - в одному з попередніх листів адресат натиснув “Це спам”.
         * Приклад: `unsubscribed`.
         */
        public string $cause,
        /**
         * Коли було встановлено недоступність, у часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
         * Приклад: `2021-12-19 10:15:49`.
         */
        public ?string $created = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: Data::string($data['email'] ?? null) ?? '',
            cause: Data::string($data['cause'] ?? null) ?? '',
            created: Data::string($data['created'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
            'cause' => $this->cause,
            'created' => $this->created,
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
