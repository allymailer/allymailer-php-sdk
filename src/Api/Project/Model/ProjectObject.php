<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт із властивостями проєкту.
 */
final class ProjectObject implements \JsonSerializable
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
