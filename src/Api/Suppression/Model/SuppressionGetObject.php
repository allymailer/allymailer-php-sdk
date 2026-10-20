<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт з даними про блокування email.
 */
final class SuppressionGetObject implements \JsonSerializable
{
    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     * Приклад: `6123462132634`.
     *
     * @var string|null
     */
    private $projectId;

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
     *
     * @var string|null
     */
    private $cause;

    /**
     * Джерело потрапляння до списку недоступних. Одне з таких:
     *
     * - __user__ - дії користувача за допомогою методу [suppression/set](https://docs.allymailer.com.ua/ua/web-api-ref#suppression-set);
     * - __system__ - надсилання на цю адресу заборонено системою, наприклад через багаторазові недоставки;
     * - __subscriber__ - у зв'язку з діями отримувача. В одному з попередніх листів адресат натиснув “Це спам” або відписався.
     * Приклад: `user`.
     *
     * @var string|null
     */
    private $source;

    /**
     * Чи можна видалити запис за допомогою виклику suppression/delete.
     *
     * @var bool|null
     */
    private $isDeletable;

    /**
     * Коли було встановлено недоступність, у часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     * Приклад: `2021-12-19 10:15:49`.
     *
     * @var string|null
     */
    private $created;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->cause = Data::string($data['cause'] ?? null);
        $model->source = Data::string($data['source'] ?? null);
        $model->isDeletable = Data::bool($data['is_deletable'] ?? null);
        $model->created = Data::string($data['created'] ?? null);

        return $model;
    }

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Причина, з якої надсилання на цей email блокується.
     */
    public function getCause(): ?string
    {
        return $this->cause;
    }

    /**
     * Причина, з якої надсилання на цей email блокується.
     *
     * @return $this
     */
    public function setCause(?string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Джерело потрапляння до списку недоступних.
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * Джерело потрапляння до списку недоступних.
     *
     * @return $this
     */
    public function setSource(?string $source): self
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Чи можна видалити запис за допомогою виклику suppression/delete.
     */
    public function getIsDeletable(): ?bool
    {
        return $this->isDeletable;
    }

    /**
     * Чи можна видалити запис за допомогою виклику suppression/delete.
     *
     * @return $this
     */
    public function setIsDeletable(?bool $isDeletable): self
    {
        $this->isDeletable = $isDeletable;

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
            'project_id' => $this->projectId,
            'cause' => $this->cause,
            'source' => $this->source,
            'is_deletable' => $this->isDeletable,
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
