<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт з даними про блокування email.
 */
final class SuppressionGetObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
         * Приклад: `6123462132634`.
         */
        public ?string $projectId = null,
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
         * - __blocked__ - надсилання на цю адресу заборонено адміністрацією AllyMailer.
         * У майбутньому можуть з'явитися й інші причини.
         * Приклад: `unsubscribed`.
         */
        public ?string $cause = null,
        /**
         * Джерело потрапляння до списку недоступних. Одне з таких:
         *
         * - __user__ - дії користувача за допомогою методу [suppression/set](https://docs.allymailer.com.ua/ua/web-api-ref#suppression-set);
         * - __system__ - надсилання на цю адресу заборонено системою, наприклад через багаторазові недоставки;
         * - __subscriber__ - у зв'язку з діями отримувача. В одному з попередніх листів адресат натиснув “Це спам” або відписався.
         * Приклад: `user`.
         */
        public ?string $source = null,
        /**
         * Чи можна видалити запис за допомогою виклику suppression/delete.
         */
        public ?bool $isDeletable = null,
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
            projectId: Data::string($data['project_id'] ?? null),
            cause: Data::string($data['cause'] ?? null),
            source: Data::string($data['source'] ?? null),
            isDeletable: Data::bool($data['is_deletable'] ?? null),
            created: Data::string($data['created'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'project_id' => $this->projectId,
            'cause' => $this->cause,
            'source' => $this->source,
            'is_deletable' => $this->isDeletable,
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
