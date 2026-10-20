<?php

declare(strict_types=1);

namespace AllyMailer\Api\EmailValidation\Model;

use AllyMailer\Client\Data;

/**
 * EmailValidationSingleResponse
 */
final class EmailValidationSingleResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Email, що перевіряється.
     *
     * @var string|null
     */
    private $email;

    /**
     * Можливі статуси:
     *
     * - "valid" - email-адреса дійсна,
     * - "invalid" - email-адреса недійсна,
     * - "suspicious" - email-адреса підозріла,
     * - "unknown" - адресу не вдалося перевірити. Приймаючий сервер не відповів у межах припустимого часу перевірки.
     * Приклад: `suspicious`.
     *
     * @var string|null
     */
    private $result;

    /**
     * Можливі статуси:
     *
     * - "no_mx_record" - у домену відсутні MX-записи,
     * - "syntax_error" - адреса не відповідає стандартам email,
     * - "possible_typo" - можливо, адресу введено з помилкою,
     * - "mailbox_not_found" - адреса не існує,
     * - "global_suppression" - адреса перманентно недоступна в сервісі через багаторазові недоставки,
     * - "disposable" - одноразовий email, зазвичай такі адреси приймають пошту лише декілька хвилин,
     * - "role" - загальна адреса електронної пошти, найчастіше використовується групою людей і не належить конкретній особі,
     * - "abuse" - адреси, з яких надходить велика кількість скарг і натискань на "спам", іноді навіть в автоматичному режимі,
     * - "spamtrap" - адреси-спам-пастки, зазвичай розміщуються поштовими провайдерами у відкритому доступі, але ніколи не використовуються для підписки. Надсилання листів на такі адреси сильно шкодить репутації відправника,
     * - "smtp_connection_failed" - SMTP-сервер недоступний — можливо, адресу введено з помилкою.
     * Приклад: `disposable`.
     *
     * @var string|null
     */
    private $cause;

    /**
     * Імовірність того, що адреса дійсна. Від 0 до 100 (100 - дійсна, 0 - недійсна).
     * Приклад: `10`.
     *
     * @var int|null
     */
    private $validity;

    /**
     * Локальна частина email-адреси (усе, що перед знаком "@").
     * Приклад: `user`.
     *
     * @var string|null
     */
    private $localPart;

    /**
     * Доменна частина email-адреси.
     * Приклад: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Чи є у домену MX-запис? true якщо є, false якщо відсутній.
     * Приклад: `True`.
     *
     * @var bool|null
     */
    private $mxFound;

    /**
     * Бажана MX-запис домену.
     * Приклад: `10`.
     *
     * @var string|null
     */
    private $mxRecord;

    /**
     * Можлива адреса, отримана після виправлення помилки (для cause=possible_typo).
     * Приклад: `user@example.com`.
     *
     * @var string|null
     */
    private $didYouMean;

    /**
     * Дата й час перевірки адреси у форматі РРРР-ММ-ДД гг:хх:сс у часовому поясі UTC.
     * Приклад: `2023-01-01 22:14:59`.
     *
     * @var string|null
     */
    private $processedAt;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->email = Data::string($data['email'] ?? null);
        $model->result = Data::string($data['result'] ?? null);
        $model->cause = Data::string($data['cause'] ?? null);
        $model->validity = Data::int($data['validity'] ?? null);
        $model->localPart = Data::string($data['local_part'] ?? null);
        $model->domain = Data::string($data['domain'] ?? null);
        $model->mxFound = Data::bool($data['mx_found'] ?? null);
        $model->mxRecord = Data::string($data['mx_record'] ?? null);
        $model->didYouMean = Data::string($data['did_you_mean'] ?? null);
        $model->processedAt = Data::string($data['processed_at'] ?? null);

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
     * Email, що перевіряється.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Email, що перевіряється.
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Можливі статуси:
     */
    public function getResult(): ?string
    {
        return $this->result;
    }

    /**
     * Можливі статуси:
     *
     * @return $this
     */
    public function setResult(?string $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Можливі статуси:
     */
    public function getCause(): ?string
    {
        return $this->cause;
    }

    /**
     * Можливі статуси:
     *
     * @return $this
     */
    public function setCause(?string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Імовірність того, що адреса дійсна.
     */
    public function getValidity(): ?int
    {
        return $this->validity;
    }

    /**
     * Імовірність того, що адреса дійсна.
     *
     * @return $this
     */
    public function setValidity(?int $validity): self
    {
        $this->validity = $validity;

        return $this;
    }

    /**
     * Локальна частина email-адреси (усе, що перед знаком "@").
     */
    public function getLocalPart(): ?string
    {
        return $this->localPart;
    }

    /**
     * Локальна частина email-адреси (усе, що перед знаком "@").
     *
     * @return $this
     */
    public function setLocalPart(?string $localPart): self
    {
        $this->localPart = $localPart;

        return $this;
    }

    /**
     * Доменна частина email-адреси.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Доменна частина email-адреси.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Чи є у домену MX-запис? true якщо є, false якщо відсутній.
     */
    public function getMxFound(): ?bool
    {
        return $this->mxFound;
    }

    /**
     * Чи є у домену MX-запис? true якщо є, false якщо відсутній.
     *
     * @return $this
     */
    public function setMxFound(?bool $mxFound): self
    {
        $this->mxFound = $mxFound;

        return $this;
    }

    /**
     * Бажана MX-запис домену.
     */
    public function getMxRecord(): ?string
    {
        return $this->mxRecord;
    }

    /**
     * Бажана MX-запис домену.
     *
     * @return $this
     */
    public function setMxRecord(?string $mxRecord): self
    {
        $this->mxRecord = $mxRecord;

        return $this;
    }

    /**
     * Можлива адреса, отримана після виправлення помилки (для cause=possible_typo).
     */
    public function getDidYouMean(): ?string
    {
        return $this->didYouMean;
    }

    /**
     * Можлива адреса, отримана після виправлення помилки (для cause=possible_typo).
     *
     * @return $this
     */
    public function setDidYouMean(?string $didYouMean): self
    {
        $this->didYouMean = $didYouMean;

        return $this;
    }

    /**
     * Дата й час перевірки адреси у форматі РРРР-ММ-ДД гг:хх:сс у часовому поясі UTC.
     */
    public function getProcessedAt(): ?string
    {
        return $this->processedAt;
    }

    /**
     * Дата й час перевірки адреси у форматі РРРР-ММ-ДД гг:хх:сс у часовому поясі UTC.
     *
     * @return $this
     */
    public function setProcessedAt(?string $processedAt): self
    {
        $this->processedAt = $processedAt;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'email' => $this->email,
            'result' => $this->result,
            'cause' => $this->cause,
            'validity' => $this->validity,
            'local_part' => $this->localPart,
            'domain' => $this->domain,
            'mx_found' => $this->mxFound,
            'mx_record' => $this->mxRecord,
            'did_you_mean' => $this->didYouMean,
            'processed_at' => $this->processedAt,
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
