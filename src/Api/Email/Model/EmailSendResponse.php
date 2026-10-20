<?php

declare(strict_types=1);

namespace AllyMailer\Api\Email\Model;

use AllyMailer\Client\Data;

/**
 * EmailSendResponse
 */
final class EmailSendResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Ідентифікатор завдання з надсилання, може виявитися корисним під час з'ясування причин збоїв.
         * Приклад: `1ZymBc-00041N-9X`.
         */
        public ?string $jobId = null,
        /**
         * Масив email-адрес, успішно прийнятих до надсилання.
         * @var list<string>|null
         */
        public ?array $emails = null,
        /**
         * Об'єкт із email-адресами, не прийнятими до надсилання. Email представлено іменем властивості, а його статус —
         * значенням властивості, наприклад: {"email1@gmail.com": "temporary_unavailable"}. Можливі статуси адрес, на які
         * не вдалося здійснити надсилання:
         *
         * - __unsubscribed__ — зазначену адресу відписано;
         * - __invalid__ — адреса не існує або введена некоректно;
         * - __duplicate__ — адреса повторюється в запиті, повторне надсилання на той самий email запобігнуто;
         * - __temporary_unavailable__ — адреса тимчасово недоступна. Це означає, що протягом наступних трьох діб надсилання на цю адресу повертатиме помилку. Email може бути тимчасово недоступним з різних причин, наприклад:
         *
         * - попереднє надсилання було відхилено сервером отримувача як спам;
         * - поштова скринька отримувача переповнена або не використовується;
         * - домен не приймає пошту через неправильне налаштування на боці отримувача або з інших причин;
         * - сервер відправника було відхилено через блеклистинг;
         *
         * - __permanent_unavailable__ — адреса перманентно недоступна через багаторазові недоставки;
         * - __complained__ — в одному з попередніх листів адресат натиснув “Це спам”;
         * - __blocked__ — надсилання на цю адресу заборонено адміністрацією AllyMailer.
         * У майбутньому можуть з'явитися й інші статуси.
         * @var array<string, string>|null
         */
        public ?array $failedEmails = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            jobId: Data::string($data['job_id'] ?? null),
            emails: Data::list($data['emails'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            failedEmails: Data::map($data['failed_emails'] ?? null, static fn ($item) => Data::string($item) ?? ''),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'job_id' => $this->jobId,
            'emails' => $this->emails,
            'failed_emails' => Data::object($this->failedEmails),
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
