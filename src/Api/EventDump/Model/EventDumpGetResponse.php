<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * EventDumpGetResponse
 */
final class EventDumpGetResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Об'єкт із властивостями дампа подій.
     *
     * @var EventDumpObject|null
     */
    private $eventDump;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->eventDump = Data::model(EventDumpObject::class, $data['event_dump'] ?? null);

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
     * Об'єкт із властивостями дампа подій.
     */
    public function getEventDump(): ?EventDumpObject
    {
        return $this->eventDump;
    }

    /**
     * Об'єкт із властивостями дампа подій.
     *
     * @return $this
     */
    public function setEventDump(?EventDumpObject $eventDump): self
    {
        $this->eventDump = $eventDump;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'event_dump' => null === $this->eventDump ? null : Data::object($this->eventDump->toArray()),
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
