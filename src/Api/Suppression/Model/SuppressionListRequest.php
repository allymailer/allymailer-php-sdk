<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * SuppressionListRequest
 */
final class SuppressionListRequest implements \JsonSerializable
{
    public function __construct(
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
         * Дата у форматі РРРР-ММ-ДД гг:хх:сс, щоб отримати список блокування з "start_time" по сьогоднішній день.
         * Ігнорується, якщо параметр “cursor” не порожній.
         * Приклад: `2020-10-14 17:00:00`.
         */
        public ?string $startTime = null,
        /**
         * Параметр указує, з якої позиції починати вибірку. Має бути порожнім або відсутнім для отримання першої порції
         * даних; для отримання другої та наступних порцій його необхідно задавати, підставляючи значення поля "cursor" з
         * попередньої порції.
         * Приклад: `Ajfb6Hvdkn3hdhhvG57xbdufhG5`.
         */
        public ?string $cursor = null,
        /**
         * Максимум записів, що видаються за один раз, за замовчуванням 50.
         * Приклад: `50`.
         */
        public ?int $limit = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            cause: Data::string($data['cause'] ?? null),
            source: Data::string($data['source'] ?? null),
            startTime: Data::string($data['start_time'] ?? null),
            cursor: Data::string($data['cursor'] ?? null),
            limit: Data::int($data['limit'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'cause' => $this->cause,
            'source' => $this->source,
            'start_time' => $this->startTime,
            'cursor' => $this->cursor,
            'limit' => $this->limit,
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
