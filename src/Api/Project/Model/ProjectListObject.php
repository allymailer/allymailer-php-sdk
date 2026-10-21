<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\EmailCounterMode;

/**
 * ProjectListObject
 */
final class ProjectListObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
         * Приклад: `6123462132634`.
         */
        public ?string $id = null,
        /**
         * API-ключ проєкту. Ви можете використовувати цей ключ замість користувацького api_key у всіх методах, крім
         * project-методів.
         */
        public ?string $apiKey = null,
        /**
         * Назва проєкту, унікальна в межах облікового запису користувача.
         * Приклад: `Project 1A`.
         */
        public ?string $name = null,
        /**
         * Двобуквений код країни за правилами ISO-3166 alpha-2. Якщо задано, то AllyMailer обробляє персональні дані
         * проєкту відповідно до законів заданої країни — наприклад, відповідно до GDPR для європейських країн.
         * Приклад: `ES`.
         */
        public ?string $country = null,
        /**
         * Дата й час створення проєкту в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
         * Приклад: `2020-12-28 17:15:45`.
         */
        public ?string $regTime = null,
        /**
         * Чи дозволено надсилання листів для проєкту.
         * За замовчуванням: `True`.
         */
        public ?bool $sendEnabled = null,
        /**
         * Якщо false, то AllyMailer додає в кінець кожного листа системне посилання відписки. Значення true вимикає
         * автоматичне додавання системою посилання відписки в кінець листа й дозволяє використовувати власне посилання
         * відписки або надсилати листи зовсім без посилання відписки. Докладніше див.
         * [тут](https://docs.allymailer.com.ua/ua/unsubscribe-link). Якщо ви не вказуєте значення
         * custom_unsubscribe_url_enabled під час створення проєкту — то це значення копіюється з головного облікового
         * запису (якщо в головному обліковому записі було встановлено примусове вимкнення посилання відписки — то й у
         * проєкту посилання відписки буде вимкнено).
         */
        public ?bool $customUnsubscribeUrlEnabled = null,
        /**
         * Унікальний ідентифікатор backend-домену, який визначає [домен посилань](/tracking-domains) або пул [виділених
         * IP-адрес](/dedicated-ip) за замовчуванням. Якщо відсутній — обліковому запису/проєкту буде призначено
         * дефолтний backend-домен за замовчуванням.
         * Приклад: `1234`.
         */
        public ?int $backendDomainId = null,
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
        /**
         * Унікальний ідентифікатор, який визначає сторінку відписки за замовчуванням. Якщо відсутній — обліковому
         * запису/проєкту буде призначено системну сторінку відписки за замовчуванням.
         * Приклад: `1`.
         */
        public ?int $unsubscribePageId = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Data::string($data['id'] ?? null),
            apiKey: Data::string($data['api_key'] ?? null),
            name: Data::string($data['name'] ?? null),
            country: Data::string($data['country'] ?? null),
            regTime: Data::string($data['reg_time'] ?? null),
            sendEnabled: Data::bool($data['send_enabled'] ?? null),
            customUnsubscribeUrlEnabled: Data::bool($data['custom_unsubscribe_url_enabled'] ?? null),
            backendDomainId: Data::int($data['backend_domain_id'] ?? null),
            emailCounter: Data::int($data['email_counter'] ?? null),
            emailCounterLimit: Data::int($data['email_counter_limit'] ?? null),
            emailCounterMode: Data::enum(EmailCounterMode::class, Data::string($data['email_counter_mode'] ?? null)),
            unsubscribePageId: Data::int($data['unsubscribe_page_id'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
            'api_key' => $this->apiKey,
            'name' => $this->name,
            'country' => $this->country,
            'reg_time' => $this->regTime,
            'send_enabled' => $this->sendEnabled,
            'custom_unsubscribe_url_enabled' => $this->customUnsubscribeUrlEnabled,
            'backend_domain_id' => $this->backendDomainId,
            'email_counter' => $this->emailCounter,
            'email_counter_limit' => $this->emailCounterLimit,
            'email_counter_mode' => Data::value($this->emailCounterMode),
            'unsubscribe_page_id' => $this->unsubscribePageId,
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
