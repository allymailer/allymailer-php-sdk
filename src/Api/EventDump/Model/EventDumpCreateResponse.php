<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * EventDumpCreateResponse
 */
final class EventDumpCreateResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Ідентифікатор дампа. Використовується для виклику методу
     * [event-dump/get](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-get).
     *
     * @var string|null
     */
    private $dumpId;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->dumpId = Data::string($data['dump_id'] ?? null);

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
     * Ідентифікатор дампа.
     */
    public function getDumpId(): ?string
    {
        return $this->dumpId;
    }

    /**
     * Ідентифікатор дампа.
     *
     * @return $this
     */
    public function setDumpId(?string $dumpId): self
    {
        $this->dumpId = $dumpId;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'dump_id' => $this->dumpId,
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
