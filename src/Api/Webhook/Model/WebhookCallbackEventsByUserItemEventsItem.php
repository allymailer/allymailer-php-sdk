<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * WebhookCallbackEventsByUserItemEventsItem
 */
final class WebhookCallbackEventsByUserItemEventsItem implements \JsonSerializable
{
    /**
     * Тип даних, що містяться в об'єкті event_data. Або "transactional_email_status", або
     * "transactional_spam_block".
     * Значення: константи `EventName`.
     *
     * @var string|null
     */
    private $eventName;

    /**
     * Об'єкт з різними властивостями події, що залежать від поля "event_name". Нижче перелічено всі можливі
     * властивості, спочатку для події "transactional_email_status", потім для події "transactional_spam_block".
     *
     * @var WebhookCallbackEventsByUserItemEventsItemEventData|null
     */
    private $eventData;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->eventName = Data::string($data['event_name'] ?? null);
        $model->eventData = Data::model(WebhookCallbackEventsByUserItemEventsItemEventData::class, $data['event_data'] ?? null);

        return $model;
    }

    /**
     * Тип даних, що містяться в об'єкті event_data.
     *
     * @return string|null
     */
    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    /**
     * Тип даних, що містяться в об'єкті event_data.
     *
     * @param string|null $eventName Значення: константи `EventName`.
     *
     * @return $this
     */
    public function setEventName(?string $eventName): self
    {
        $this->eventName = $eventName;

        return $this;
    }

    /**
     * Об'єкт з різними властивостями події, що залежать від поля "event_name".
     */
    public function getEventData(): ?WebhookCallbackEventsByUserItemEventsItemEventData
    {
        return $this->eventData;
    }

    /**
     * Об'єкт з різними властивостями події, що залежать від поля "event_name".
     *
     * @return $this
     */
    public function setEventData(?WebhookCallbackEventsByUserItemEventsItemEventData $eventData): self
    {
        $this->eventData = $eventData;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'event_name' => $this->eventName,
            'event_data' => null === $this->eventData ? null : Data::object($this->eventData->toArray()),
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
