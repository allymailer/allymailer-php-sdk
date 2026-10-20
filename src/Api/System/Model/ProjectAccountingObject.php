<?php

declare(strict_types=1);

namespace AllyMailer\Api\System\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\EmailCounterMode;

/**
 * Об'єкт із властивостями лічильника листів. Присутній лише якщо API-ключ, використаний для запиту, був
 * API-ключем проєкту.
 */
final class ProjectAccountingObject implements \JsonSerializable
{
    /**
     * Значення лічильника листів для проєкту, збільшується під час надсилання кожного листа.
     *
     * @var int|null
     */
    private $emailCounter;

    /**
     * Дозволяє обмежити кількість надісланих проєктом листів. У разі досягнення цього ліміту надсилання
     * припиняється. Значення 0 (за замовчуванням) означає відсутність ліміту.
     *
     * @var int|null
     */
    private $emailCounterLimit;

    /**
     * 'default' - лічильник автоматично скидається в нуль на початку кожного облікового періоду, 'permanent' -
     * лічильник ніколи не скидається автоматично.
     * За замовчуванням: `default`.
     * Значення: константи `EmailCounterMode`.
     *
     * @var string|null
     */
    private $emailCounterMode;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->emailCounter = Data::int($data['email_counter'] ?? null);
        $model->emailCounterLimit = Data::int($data['email_counter_limit'] ?? null);
        $model->emailCounterMode = Data::string($data['email_counter_mode'] ?? null);

        return $model;
    }

    /**
     * Значення лічильника листів для проєкту, збільшується під час надсилання кожного листа.
     */
    public function getEmailCounter(): ?int
    {
        return $this->emailCounter;
    }

    /**
     * Значення лічильника листів для проєкту, збільшується під час надсилання кожного листа.
     *
     * @return $this
     */
    public function setEmailCounter(?int $emailCounter): self
    {
        $this->emailCounter = $emailCounter;

        return $this;
    }

    /**
     * Дозволяє обмежити кількість надісланих проєктом листів.
     */
    public function getEmailCounterLimit(): ?int
    {
        return $this->emailCounterLimit;
    }

    /**
     * Дозволяє обмежити кількість надісланих проєктом листів.
     *
     * @return $this
     */
    public function setEmailCounterLimit(?int $emailCounterLimit): self
    {
        $this->emailCounterLimit = $emailCounterLimit;

        return $this;
    }

    /**
     * 'default' - лічильник автоматично скидається в нуль на початку кожного облікового періоду, 'permanent' -
     * лічильник ніколи не скидається автоматично.
     *
     * @return string|null
     */
    public function getEmailCounterMode(): ?string
    {
        return $this->emailCounterMode;
    }

    /**
     * 'default' - лічильник автоматично скидається в нуль на початку кожного облікового періоду, 'permanent' -
     * лічильник ніколи не скидається автоматично.
     *
     * @param string|null $emailCounterMode Значення: константи `EmailCounterMode`.
     *
     * @return $this
     */
    public function setEmailCounterMode(?string $emailCounterMode): self
    {
        $this->emailCounterMode = $emailCounterMode;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email_counter' => $this->emailCounter,
            'email_counter_limit' => $this->emailCounterLimit,
            'email_counter_mode' => $this->emailCounterMode,
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
