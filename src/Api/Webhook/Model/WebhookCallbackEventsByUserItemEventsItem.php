<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * WebhookCallbackEventsByUserItemEventsItem
 */
final class WebhookCallbackEventsByUserItemEventsItem implements \JsonSerializable
{
    public function __construct(
        /**
         * Тип даних, що містяться в об'єкті event_data. Або "transactional_email_status", або
         * "transactional_spam_block".
         */
        public EventName|string|null $eventName = null,
        /**
         * Об'єкт з різними властивостями події, що залежать від поля "event_name". Нижче перелічено всі можливі
         * властивості, спочатку для події "transactional_email_status", потім для події "transactional_spam_block".
         */
        public ?WebhookCallbackEventsByUserItemEventsItemEventData $eventData = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            eventName: Data::enum(EventName::class, Data::string($data['event_name'] ?? null)),
            eventData: Data::model(WebhookCallbackEventsByUserItemEventsItemEventData::class, $data['event_data'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'event_name' => Data::value($this->eventName),
            'event_data' => null === $this->eventData ? null : Data::object($this->eventData->toArray()),
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
