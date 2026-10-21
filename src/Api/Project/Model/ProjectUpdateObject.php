<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\EmailCounterMode;

/**
 * Об'єкт із властивостями проєкту.
 */
final class ProjectUpdateObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Назва проєкту, унікальна в межах облікового запису користувача.
         * Приклад: `Project 1A`.
         */
        public string $name,
        /**
         * Двобуквений код країни за правилами ISO-3166 alpha-2. Якщо задано, то AllyMailer обробляє персональні дані
         * проєкту відповідно до законів заданої країни — наприклад, відповідно до GDPR для європейських країн.
         * Приклад: `ES`.
         */
        public ?string $country = null,
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
         * Унікальний ідентифікатор, який визначає сторінку відписки за замовчуванням. Якщо відсутній — обліковому
         * запису/проєкту буде призначено системну сторінку відписки за замовчуванням.
         * Приклад: `1`.
         */
        public ?int $unsubscribePageId = null,
        /**
         * Значення лічильника листів для проєкту, збільшується під час надсилання кожного листа. Приймає лише значення 0
         * (тобто скидання лічильника в нуль) або оновлюється автоматично, залежно від режиму роботи лічильника, заданого
         * параметром 'email_counter_mode'. Якщо поле не передано в запиті або передано null, то значення лічильника не
         * змінюється.
         */
        public ?int $emailCounter = null,
        /**
         * Дозволяє обмежити кількість надісланих проєктом листів. У разі досягнення цього ліміту надсилання
         * припиняється. Приймається будь-яке невід'ємне 64-бітне ціле число. Значення 0 означає відсутність ліміту. Якщо
         * поле не передано в запиті або передано null, то значення ліміту не змінюється.
         * За замовчуванням: `0`.
         */
        public ?int $emailCounterLimit = null,
        /**
         * Встановлює режим роботи лічильника листів. Дозволяє вибрати, як має поводитися лічильник: автоматично
         * скидатися чи залишатися постійним. Припустимі значення: default - лічильник автоматично скидається в нуль на
         * початку кожного облікового періоду, permanent - лічильник ніколи не скидається автоматично. Скидання може бути
         * виконане лише вручну користувачем, передавши значення 0 у полі 'email_counter'. Якщо поле не передано в запиті
         * або передано значення null, значення режиму не змінюється.
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
            name: Data::string($data['name'] ?? null) ?? '',
            country: Data::string($data['country'] ?? null),
            sendEnabled: Data::bool($data['send_enabled'] ?? null),
            customUnsubscribeUrlEnabled: Data::bool($data['custom_unsubscribe_url_enabled'] ?? null),
            backendDomainId: Data::int($data['backend_domain_id'] ?? null),
            unsubscribePageId: Data::int($data['unsubscribe_page_id'] ?? null),
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
            'name' => $this->name,
            'country' => $this->country,
            'send_enabled' => $this->sendEnabled,
            'custom_unsubscribe_url_enabled' => $this->customUnsubscribeUrlEnabled,
            'backend_domain_id' => $this->backendDomainId,
            'unsubscribe_page_id' => $this->unsubscribePageId,
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
