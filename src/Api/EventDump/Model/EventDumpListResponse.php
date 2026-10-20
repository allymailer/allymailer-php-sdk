<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * EventDumpListResponse
 */
final class EventDumpListResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Масив об'єктів, що описують дампи подій. Кожен об'єкт містить ті самі властивості, що й об'єкт 'event_dump',
     * який повертає метод [event-dump/get](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-get).
     *
     * @var list<EventDumpObject>|null
     */
    private $eventDumps;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->eventDumps = Data::list($data['event_dumps'] ?? null, static function ($item) { return EventDumpObject::fromArray(Data::array($item) ?? []); });

        return $model;
    }

    /**
     * Рядок "success".
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Рядок "success".
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Масив об'єктів, що описують дампи подій.
     *
     * @return list<EventDumpObject>|null
     */
    public function getEventDumps(): ?array
    {
        return $this->eventDumps;
    }

    /**
     * Масив об'єктів, що описують дампи подій.
     *
     * @param list<EventDumpObject>|null $eventDumps
     *
     * @return $this
     */
    public function setEventDumps(?array $eventDumps): self
    {
        $this->eventDumps = $eventDumps;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'event_dumps' => null === $this->eventDumps ? null : \array_map(static function (EventDumpObject $item) { return Data::object($item->toArray()); }, $this->eventDumps),
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
