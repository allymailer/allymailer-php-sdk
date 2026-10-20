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
    public function __construct(
        /**
         * Значення лічильника листів для проєкту, збільшується під час надсилання кожного листа.
         */
        public ?int $emailCounter = null,
        /**
         * Дозволяє обмежити кількість надісланих проєктом листів. У разі досягнення цього ліміту надсилання
         * припиняється. Значення 0 (за замовчуванням) означає відсутність ліміту.
         */
        public ?int $emailCounterLimit = null,
        /**
         * 'default' - лічильник автоматично скидається в нуль на початку кожного облікового періоду, 'permanent' -
         * лічильник ніколи не скидається автоматично.
         * За замовчуванням: `default`.
         */
        public EmailCounterMode|string|null $emailCounterMode = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            emailCounter: Data::int($data['email_counter'] ?? null),
            emailCounterLimit: Data::int($data['email_counter_limit'] ?? null),
            emailCounterMode: Data::enum(EmailCounterMode::class, Data::string($data['email_counter_mode'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email_counter' => $this->emailCounter,
            'email_counter_limit' => $this->emailCounterLimit,
            'email_counter_mode' => Data::value($this->emailCounterMode),
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
