<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт з усіма властивостями webhook.
 */
final class WebhookObject implements \JsonSerializable
{
    /**
     * Унікальний ідентифікатор webhook.
     *
     * @var int|null
     */
    private $id;

    /**
     * URL webhook.
     *
     * @var string|null
     */
    private $url;

    /**
     * Статус webhook, за замовчуванням "active". Статус "disabled" означає, що webhook було вимкнено користувачем,
     * "stopped" означає, що webhook було зупинено системою після 24 годин невдалих викликів (мінімум за 10 різними
     * подіями).
     * За замовчуванням: `active`.
     * Значення: константи `WebhookStatus`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Формат сповіщень. "json_post"(за замовчуванням) або "json_post_gzip".
     * За замовчуванням: `json_post`.
     * Значення: константи `WebhookEventFormat`.
     *
     * @var string|null
     */
    private $eventFormat;

    /**
     * Повертати (1) чи ні (0) докладну інформацію про доставку. Якщо delivery_info=1, повертається додаткова
     * інформація про відповідь сервера та внутрішній статус доставки в разі статусів доставки "hard_bounced" і
     * "soft_bounced"; user agent, IP-адреса отримувача, геодані, визначена за user agent інформація про пристрій
     * (тип і марка пристрою, назва ОС, браузера або поштового клієнта) і traffic_type (human, machine, protected або
     * unknown) в разі статусів "opened" і "clicked"; URL для статусу "clicked". Для статусів "delivered",
     * "soft_bounced" і "hard_bounced" AllyMailer також може повернути sender_ip — IP-адресу SMTP-сервера, з якого
     * було надіслано лист, якщо він доступний.
     * Допустимі значення: `0`, `1`.
     * За замовчуванням: `0`.
     *
     * @var int|null
     */
    private $deliveryInfo;

    /**
     * 0=в одному виклику може надійти декілька подій, 1=лише одна подія на виклик (не рекомендується).
     * Допустимі значення: `0`, `1`.
     * За замовчуванням: `0`.
     *
     * @var int|null
     */
    private $singleEvent;

    /**
     * Максимальна кількість дозволених паралельних запитів до вашого сервера. Чим більше ваш сервер може обробити —
     * тим краще.
     * За замовчуванням: `10`.
     *
     * @var int|null
     */
    private $maxParallel;

    /**
     * Час останнього оновлення властивостей webhook у часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     *
     * @var string|null
     */
    private $updatedAt;

    /**
     * Об'єкт, що описує події, про які потрібно сповіщати.
     *
     * @var WebhookEventsObject|null
     */
    private $events;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->id = Data::int($data['id'] ?? null);
        $model->url = Data::string($data['url'] ?? null);
        $model->status = Data::string($data['status'] ?? null);
        $model->eventFormat = Data::string($data['event_format'] ?? null);
        $model->deliveryInfo = Data::int($data['delivery_info'] ?? null);
        $model->singleEvent = Data::int($data['single_event'] ?? null);
        $model->maxParallel = Data::int($data['max_parallel'] ?? null);
        $model->updatedAt = Data::string($data['updated_at'] ?? null);
        $model->events = Data::model(WebhookEventsObject::class, $data['events'] ?? null);

        return $model;
    }

    /**
     * Унікальний ідентифікатор webhook.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Унікальний ідентифікатор webhook.
     *
     * @return $this
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * URL webhook.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * URL webhook.
     *
     * @return $this
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Статус webhook, за замовчуванням "active".
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Статус webhook, за замовчуванням "active".
     *
     * @param string|null $status Значення: константи `WebhookStatus`.
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Формат сповіщень. "json_post"(за замовчуванням) або "json_post_gzip".
     *
     * @return string|null
     */
    public function getEventFormat(): ?string
    {
        return $this->eventFormat;
    }

    /**
     * Формат сповіщень. "json_post"(за замовчуванням) або "json_post_gzip".
     *
     * @param string|null $eventFormat Значення: константи `WebhookEventFormat`.
     *
     * @return $this
     */
    public function setEventFormat(?string $eventFormat): self
    {
        $this->eventFormat = $eventFormat;

        return $this;
    }

    /**
     * Повертати (1) чи ні (0) докладну інформацію про доставку.
     */
    public function getDeliveryInfo(): ?int
    {
        return $this->deliveryInfo;
    }

    /**
     * Повертати (1) чи ні (0) докладну інформацію про доставку.
     *
     * @return $this
     */
    public function setDeliveryInfo(?int $deliveryInfo): self
    {
        $this->deliveryInfo = $deliveryInfo;

        return $this;
    }

    /**
     * 0=в одному виклику може надійти декілька подій, 1=лише одна подія на виклик (не рекомендується).
     */
    public function getSingleEvent(): ?int
    {
        return $this->singleEvent;
    }

    /**
     * 0=в одному виклику може надійти декілька подій, 1=лише одна подія на виклик (не рекомендується).
     *
     * @return $this
     */
    public function setSingleEvent(?int $singleEvent): self
    {
        $this->singleEvent = $singleEvent;

        return $this;
    }

    /**
     * Максимальна кількість дозволених паралельних запитів до вашого сервера.
     */
    public function getMaxParallel(): ?int
    {
        return $this->maxParallel;
    }

    /**
     * Максимальна кількість дозволених паралельних запитів до вашого сервера.
     *
     * @return $this
     */
    public function setMaxParallel(?int $maxParallel): self
    {
        $this->maxParallel = $maxParallel;

        return $this;
    }

    /**
     * Час останнього оновлення властивостей webhook у часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Час останнього оновлення властивостей webhook у часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     *
     * @return $this
     */
    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Об'єкт, що описує події, про які потрібно сповіщати.
     */
    public function getEvents(): ?WebhookEventsObject
    {
        return $this->events;
    }

    /**
     * Об'єкт, що описує події, про які потрібно сповіщати.
     *
     * @return $this
     */
    public function setEvents(?WebhookEventsObject $events): self
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
            'url' => $this->url,
            'status' => $this->status,
            'event_format' => $this->eventFormat,
            'delivery_info' => $this->deliveryInfo,
            'single_event' => $this->singleEvent,
            'max_parallel' => $this->maxParallel,
            'updated_at' => $this->updatedAt,
            'events' => null === $this->events ? null : Data::object($this->events->toArray()),
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
