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
    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     * Приклад: `6123462132634`.
     *
     * @var string|null
     */
    private $id;

    /**
     * API-ключ проєкту. Ви можете використовувати цей ключ замість користувацького api_key у всіх методах, крім
     * project-методів.
     *
     * @var string|null
     */
    private $apiKey;

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     * Приклад: `Project 1A`.
     *
     * @var string|null
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
     * Дата й час створення проєкту в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     * Приклад: `2020-12-28 17:15:45`.
     *
     * @var string|null
     */
    private $regTime;

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
     * [тут](https://docs.allymailer.com.ua/en/unsubscribe-link). Якщо ви не вказуєте значення
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
     * Унікальний ідентифікатор, який визначає сторінку відписки за замовчуванням. Якщо відсутній — обліковому
     * запису/проєкту буде призначено системну сторінку відписки за замовчуванням.
     * Приклад: `1`.
     *
     * @var int|null
     */
    private $unsubscribePageId;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->id = Data::string($data['id'] ?? null);
        $model->apiKey = Data::string($data['api_key'] ?? null);
        $model->name = Data::string($data['name'] ?? null);
        $model->country = Data::string($data['country'] ?? null);
        $model->regTime = Data::string($data['reg_time'] ?? null);
        $model->sendEnabled = Data::bool($data['send_enabled'] ?? null);
        $model->customUnsubscribeUrlEnabled = Data::bool($data['custom_unsubscribe_url_enabled'] ?? null);
        $model->backendDomainId = Data::int($data['backend_domain_id'] ?? null);
        $model->emailCounter = Data::int($data['email_counter'] ?? null);
        $model->emailCounterLimit = Data::int($data['email_counter_limit'] ?? null);
        $model->emailCounterMode = Data::string($data['email_counter_mode'] ?? null);
        $model->unsubscribePageId = Data::int($data['unsubscribe_page_id'] ?? null);

        return $model;
    }

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     *
     * @return $this
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * API-ключ проєкту.
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    /**
     * API-ключ проєкту.
     *
     * @return $this
     */
    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     *
     * @return $this
     */
    public function setName(?string $name): self
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
     * Дата й час створення проєкту в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     */
    public function getRegTime(): ?string
    {
        return $this->regTime;
    }

    /**
     * Дата й час створення проєкту в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     *
     * @return $this
     */
    public function setRegTime(?string $regTime): self
    {
        $this->regTime = $regTime;

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
            'email_counter_mode' => $this->emailCounterMode,
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
