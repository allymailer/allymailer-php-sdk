<?php

declare(strict_types=1);

namespace AllyMailer\Api\Email\Model;

use AllyMailer\Client\Data;

/**
 * EmailSendResponse
 */
final class EmailSendResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Ідентифікатор завдання з надсилання, може виявитися корисним під час з'ясування причин збоїв.
     * Приклад: `1ZymBc-00041N-9X`.
     *
     * @var string|null
     */
    private $jobId;

    /**
     * Масив email-адрес, успішно прийнятих до надсилання.
     *
     * @var list<string>|null
     */
    private $emails;

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
     *
     * @var array<string, string>|null
     */
    private $failedEmails;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->jobId = Data::string($data['job_id'] ?? null);
        $model->emails = Data::list($data['emails'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->failedEmails = Data::map($data['failed_emails'] ?? null, static function ($item) { return Data::string($item) ?? ''; });

        return $model;
    }

    /**
     * Рядок "success".
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Рядок "success".
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Ідентифікатор завдання з надсилання, може виявитися корисним під час з'ясування причин збоїв.
     */
    public function getJobId(): ?string
    {
        return $this->jobId;
    }

    /**
     * Ідентифікатор завдання з надсилання, може виявитися корисним під час з'ясування причин збоїв.
     *
     * @return $this
     */
    public function setJobId(?string $jobId): self
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Масив email-адрес, успішно прийнятих до надсилання.
     *
     * @return list<string>|null
     */
    public function getEmails(): ?array
    {
        return $this->emails;
    }

    /**
     * Масив email-адрес, успішно прийнятих до надсилання.
     *
     * @param list<string>|null $emails
     *
     * @return $this
     */
    public function setEmails(?array $emails): self
    {
        $this->emails = $emails;

        return $this;
    }

    /**
     * Об'єкт із email-адресами, не прийнятими до надсилання.
     *
     * @return array<string, string>|null
     */
    public function getFailedEmails(): ?array
    {
        return $this->failedEmails;
    }

    /**
     * Об'єкт із email-адресами, не прийнятими до надсилання.
     *
     * @param array<string, string>|null $failedEmails
     *
     * @return $this
     */
    public function setFailedEmails(?array $failedEmails): self
    {
        $this->failedEmails = $failedEmails;

        return $this;
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
