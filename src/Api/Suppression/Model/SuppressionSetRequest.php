<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * SuppressionSetRequest
 */
final class SuppressionSetRequest implements \JsonSerializable
{
    /**
     * Email-адреса, яку потрібно додати до списку недоступних.
     * Приклад: `email@example.com`.
     *
     * @var string
     */
    private $email;

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
     *
     * @var string
     */
    private $cause;

    /**
     * Коли було встановлено недоступність, у часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     * Приклад: `2021-12-19 10:15:49`.
     *
     * @var string|null
     */
    private $created;

    public function __construct(string $email, string $cause)
    {
        $this->email = $email;
        $this->cause = $cause;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(
            Data::string($data['email'] ?? null) ?? '',
            Data::string($data['cause'] ?? null) ?? ''
        );
        $model->created = Data::string($data['created'] ?? null);

        return $model;
    }

    /**
     * Email-адреса, яку потрібно додати до списку недоступних.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Email-адреса, яку потрібно додати до списку недоступних.
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Причина, з якої надсилання на цей email блокується.
     */
    public function getCause(): string
    {
        return $this->cause;
    }

    /**
     * Причина, з якої надсилання на цей email блокується.
     *
     * @return $this
     */
    public function setCause(string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Коли було встановлено недоступність, у часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     */
    public function getCreated(): ?string
    {
        return $this->created;
    }

    /**
     * Коли було встановлено недоступність, у часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     *
     * @return $this
     */
    public function setCreated(?string $created): self
    {
        $this->created = $created;

        return $this;
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
