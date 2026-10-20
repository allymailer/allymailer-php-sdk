<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete\Model;

use AllyMailer\Client\Data;

/**
 * ObsoleteUnsubscribedListRequest
 */
final class ObsoleteUnsubscribedListRequest implements \JsonSerializable
{
    /**
     * Дата у форматі РРРР-ММ-ДД, щоб отримати всі відписані адреси з "date_from" по сьогоднішній день. Якщо параметр
     * не вказати, період за замовчуванням буде з 00:00 сьогоднішнього дня за UTC.
     * Приклад: `2020-10-14`.
     *
     * @var string|null
     */
    private $dateFrom;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->dateFrom = Data::string($data['date_from'] ?? null);

        return $model;
    }

    /**
     * Дата у форматі РРРР-ММ-ДД, щоб отримати всі відписані адреси з "date_from" по сьогоднішній день.
     */
    public function getDateFrom(): ?string
    {
        return $this->dateFrom;
    }

    /**
     * Дата у форматі РРРР-ММ-ДД, щоб отримати всі відписані адреси з "date_from" по сьогоднішній день.
     *
     * @return $this
     */
    public function setDateFrom(?string $dateFrom): self
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'date_from' => $this->dateFrom,
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
