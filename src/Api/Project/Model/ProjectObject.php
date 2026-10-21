<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт із властивостями проєкту.
 */
final class ProjectObject implements \JsonSerializable
{
    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     * Приклад: `Project 1A`.
     *
     * @var string
     */
    private $name;

    /**
     * Двобуквений код країни за правилами ISO-3166 alpha-2. Якщо задано, то AllyMailer обробляє персональні дані
     * проєкту відповідно до законів заданої країни — наприклад, відповідно до GDPR для європейських країн.
     * Приклад: `ES`.
     *
     * @var string|null
     */
    private $country;

    /**
     * Чи дозволено надсилання листів для проєкту.
     * За замовчуванням: `True`.
     *
     * @var bool|null
     */
    private $sendEnabled;

    /**
     * Якщо false, то AllyMailer додає в кінець кожного листа системне посилання відписки. Значення true вимикає
     * автоматичне додавання системою посилання відписки в кінець листа й дозволяє використовувати власне посилання
     * відписки або надсилати листи зовсім без посилання відписки. Докладніше див.
     * [тут](https://docs.allymailer.com.ua/ua/unsubscribe-link). Якщо ви не вказуєте значення
     * custom_unsubscribe_url_enabled під час створення проєкту — то це значення копіюється з головного облікового
     * запису (якщо в головному обліковому записі було встановлено примусове вимкнення посилання відписки — то й у
     * проєкту посилання відписки буде вимкнено).
     *
     * @var bool|null
     */
    private $customUnsubscribeUrlEnabled;

    /**
     * Унікальний ідентифікатор backend-домену, який визначає [домен посилань](/tracking-domains) або пул [виділених
     * IP-адрес](/dedicated-ip) за замовчуванням. Якщо відсутній — обліковому запису/проєкту буде призначено
     * дефолтний backend-домен за замовчуванням.
     * Приклад: `1234`.
     *
     * @var int|null
     */
    private $backendDomainId;

    /**
     * Унікальний ідентифікатор, який визначає сторінку відписки за замовчуванням. Якщо відсутній — обліковому
     * запису/проєкту буде призначено системну сторінку відписки за замовчуванням.
     * Приклад: `1`.
     *
     * @var int|null
     */
    private $unsubscribePageId;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(Data::string($data['name'] ?? null) ?? '');
        $model->country = Data::string($data['country'] ?? null);
        $model->sendEnabled = Data::bool($data['send_enabled'] ?? null);
        $model->customUnsubscribeUrlEnabled = Data::bool($data['custom_unsubscribe_url_enabled'] ?? null);
        $model->backendDomainId = Data::int($data['backend_domain_id'] ?? null);
        $model->unsubscribePageId = Data::int($data['unsubscribe_page_id'] ?? null);

        return $model;
    }

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Двобуквений код країни за правилами ISO-3166 alpha-2.
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Двобуквений код країни за правилами ISO-3166 alpha-2.
     *
     * @return $this
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Чи дозволено надсилання листів для проєкту.
     */
    public function getSendEnabled(): ?bool
    {
        return $this->sendEnabled;
    }

    /**
     * Чи дозволено надсилання листів для проєкту.
     *
     * @return $this
     */
    public function setSendEnabled(?bool $sendEnabled): self
    {
        $this->sendEnabled = $sendEnabled;

        return $this;
    }

    /**
     * Якщо false, то AllyMailer додає в кінець кожного листа системне посилання відписки.
     */
    public function getCustomUnsubscribeUrlEnabled(): ?bool
    {
        return $this->customUnsubscribeUrlEnabled;
    }

    /**
     * Якщо false, то AllyMailer додає в кінець кожного листа системне посилання відписки.
     *
     * @return $this
     */
    public function setCustomUnsubscribeUrlEnabled(?bool $customUnsubscribeUrlEnabled): self
    {
        $this->customUnsubscribeUrlEnabled = $customUnsubscribeUrlEnabled;

        return $this;
    }

    /**
     * Унікальний ідентифікатор backend-домену, який визначає [домен посилань](/tracking-domains) або пул [виділених
     * IP-адрес](/dedicated-ip) за замовчуванням.
     */
    public function getBackendDomainId(): ?int
    {
        return $this->backendDomainId;
    }

    /**
     * Унікальний ідентифікатор backend-домену, який визначає [домен посилань](/tracking-domains) або пул [виділених
     * IP-адрес](/dedicated-ip) за замовчуванням.
     *
     * @return $this
     */
    public function setBackendDomainId(?int $backendDomainId): self
    {
        $this->backendDomainId = $backendDomainId;

        return $this;
    }

    /**
     * Унікальний ідентифікатор, який визначає сторінку відписки за замовчуванням.
     */
    public function getUnsubscribePageId(): ?int
    {
        return $this->unsubscribePageId;
    }

    /**
     * Унікальний ідентифікатор, який визначає сторінку відписки за замовчуванням.
     *
     * @return $this
     */
    public function setUnsubscribePageId(?int $unsubscribePageId): self
    {
        $this->unsubscribePageId = $unsubscribePageId;

        return $this;
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
