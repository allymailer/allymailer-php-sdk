<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * EventDumpDeleteRequest
 */
final class EventDumpDeleteRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Ідентифікатор дампа, отриманий методом
         * [event-dump/create](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-create).
         * Приклад: `Gqfasjh34tlasd`.
         */
        public string $dumpId,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dumpId: Data::string($data['dump_id'] ?? null) ?? '',
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'dump_id' => $this->dumpId,
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
