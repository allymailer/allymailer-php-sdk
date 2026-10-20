<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт із властивостями файлу дампа подій.
 */
final class EventDumpFilesObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Унікальний URL для завантаження файлу з розширенням .csv або .csv.gz, залежно від запитаного формату.
         * Приклад: `https://cp.allymailer.com/event-dump/Agejmh63Efmngaow4tDFGqwqt-1.csv`.
         */
        public ?string $url = null,
        /**
         * Розмір файлу.
         * Приклад: `512345`.
         */
        public ?int $size = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            url: Data::string($data['url'] ?? null),
            size: Data::int($data['size'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'url' => $this->url,
            'size' => $this->size,
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
