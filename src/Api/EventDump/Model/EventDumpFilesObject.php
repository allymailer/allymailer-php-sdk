<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт із властивостями файлу дампа подій.
 */
final class EventDumpFilesObject implements \JsonSerializable
{
    /**
     * Унікальний URL для завантаження файлу з розширенням .csv або .csv.gz, залежно від запитаного формату.
     * Приклад: `https://cp.allymailer.com/event-dump/Agejmh63Efmngaow4tDFGqwqt-1.csv`.
     *
     * @var string|null
     */
    private $url;

    /**
     * Розмір файлу.
     * Приклад: `512345`.
     *
     * @var int|null
     */
    private $size;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->url = Data::string($data['url'] ?? null);
        $model->size = Data::int($data['size'] ?? null);

        return $model;
    }

    /**
     * Унікальний URL для завантаження файлу з розширенням .csv або .csv.gz, залежно від запитаного формату.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Унікальний URL для завантаження файлу з розширенням .csv або .csv.gz, залежно від запитаного формату.
     *
     * @return $this
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Розмір файлу.
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * Розмір файлу.
     *
     * @return $this
     */
    public function setSize(?int $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'url' => $this->url,
            'size' => $this->size,
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
