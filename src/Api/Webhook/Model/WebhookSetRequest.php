<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * WebhookSetRequest
 */
final class WebhookSetRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок з URL, на який надсилатиметься запит у разі виникнення події (ідентифікатор обробника). В URL поки що
         * підтримуються лише ASCII-символи. Якщо вам потрібно використати не-ASCII, сконвертуйте URL у
         * [Punycode](https://en.wikipedia.org/wiki/Punycode).
         * Приклад: `https://yourhost.example.com/allymailer-webhook`.
         */
        public string $url,
        /**
         * Статус webhook, за замовчуванням "active". Статус "disabled" означає, що webhook було вимкнено користувачем,
         * "stopped" означає, що webhook було зупинено системою після 24 годин невдалих викликів (мінімум за 10 різними
         * подіями).
         * За замовчуванням: `active`.
         */
        public WebhookStatus|string|null $status = null,
        /**
         * Формат сповіщень. "json_post"(за замовчуванням) або "json_post_gzip".
         * За замовчуванням: `json_post`.
         */
        public WebhookEventFormat|string|null $eventFormat = null,
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
         */
        public ?int $deliveryInfo = null,
        /**
         * 0=в одному виклику може надійти декілька подій, 1=лише одна подія на виклик (не рекомендується).
         * Допустимі значення: `0`, `1`.
         * За замовчуванням: `0`.
         */
        public ?int $singleEvent = null,
        /**
         * Максимальна кількість дозволених паралельних запитів до вашого сервера. Чим більше ваш сервер може обробити —
         * тим краще.
         * За замовчуванням: `10`.
         */
        public ?int $maxParallel = null,
        /**
         * Об'єкт, що описує події, про які потрібно сповіщати.
         */
        public ?WebhookEventsObject $events = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: Data::string($data['url'] ?? null) ?? '',
            status: Data::enum(WebhookStatus::class, Data::string($data['status'] ?? null)),
            eventFormat: Data::enum(WebhookEventFormat::class, Data::string($data['event_format'] ?? null)),
            deliveryInfo: Data::int($data['delivery_info'] ?? null),
            singleEvent: Data::int($data['single_event'] ?? null),
            maxParallel: Data::int($data['max_parallel'] ?? null),
            events: Data::model(WebhookEventsObject::class, $data['events'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'url' => $this->url,
            'status' => Data::value($this->status),
            'event_format' => Data::value($this->eventFormat),
            'delivery_info' => $this->deliveryInfo,
            'single_event' => $this->singleEvent,
            'max_parallel' => $this->maxParallel,
            'events' => null === $this->events ? null : Data::object($this->events->toArray()),
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
