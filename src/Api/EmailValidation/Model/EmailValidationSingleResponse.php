<?php

declare(strict_types=1);

namespace AllyMailer\Api\EmailValidation\Model;

use AllyMailer\Client\Data;

/**
 * EmailValidationSingleResponse
 */
final class EmailValidationSingleResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Email, що перевіряється.
         */
        public ?string $email = null,
        /**
         * Можливі статуси:
         *
         * - "valid" - email-адреса дійсна,
         * - "invalid" - email-адреса недійсна,
         * - "suspicious" - email-адреса підозріла,
         * - "unknown" - адресу не вдалося перевірити. Приймаючий сервер не відповів у межах припустимого часу перевірки.
         * Приклад: `suspicious`.
         */
        public ?string $result = null,
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
         */
        public ?string $cause = null,
        /**
         * Імовірність того, що адреса дійсна. Від 0 до 100 (100 - дійсна, 0 - недійсна).
         * Приклад: `10`.
         */
        public ?int $validity = null,
        /**
         * Локальна частина email-адреси (усе, що перед знаком "@").
         * Приклад: `user`.
         */
        public ?string $localPart = null,
        /**
         * Доменна частина email-адреси.
         * Приклад: `example.com`.
         */
        public ?string $domain = null,
        /**
         * Чи є у домену MX-запис? true якщо є, false якщо відсутній.
         * Приклад: `True`.
         */
        public ?bool $mxFound = null,
        /**
         * Бажана MX-запис домену.
         * Приклад: `10`.
         */
        public ?string $mxRecord = null,
        /**
         * Можлива адреса, отримана після виправлення помилки (для cause=possible_typo).
         * Приклад: `user@example.com`.
         */
        public ?string $didYouMean = null,
        /**
         * Дата й час перевірки адреси у форматі РРРР-ММ-ДД гг:хх:сс у часовому поясі UTC.
         * Приклад: `2023-01-01 22:14:59`.
         */
        public ?string $processedAt = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            email: Data::string($data['email'] ?? null),
            result: Data::string($data['result'] ?? null),
            cause: Data::string($data['cause'] ?? null),
            validity: Data::int($data['validity'] ?? null),
            localPart: Data::string($data['local_part'] ?? null),
            domain: Data::string($data['domain'] ?? null),
            mxFound: Data::bool($data['mx_found'] ?? null),
            mxRecord: Data::string($data['mx_record'] ?? null),
            didYouMean: Data::string($data['did_you_mean'] ?? null),
            processedAt: Data::string($data['processed_at'] ?? null),
        );
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
