<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * EventDumpGetRequest
 */
final class EventDumpGetRequest implements \JsonSerializable
{
    /**
     * Ідентифікатор дампа, отриманий методом
     * [event-dump/create](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-create).
     * Приклад: `Gqfasjh34tlasd`.
     *
     * @var string
     */
    private $dumpId;

    public function __construct(string $dumpId)
    {
        $this->dumpId = $dumpId;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(Data::string($data['dump_id'] ?? null) ?? '');
    }

    /**
     * Ідентифікатор дампа, отриманий методом
     * [event-dump/create](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-create).
     */
    public function getDumpId(): string
    {
        return $this->dumpId;
    }

    /**
     * Ідентифікатор дампа, отриманий методом
     * [event-dump/create](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-create).
     *
     * @return $this
     */
    public function setDumpId(string $dumpId): self
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
