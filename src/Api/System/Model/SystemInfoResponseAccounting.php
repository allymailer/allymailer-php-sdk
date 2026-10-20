<?php

declare(strict_types=1);

namespace AllyMailer\Api\System\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт з властивостями періоду обліку. Присутній лише якщо API-ключ, використаний для запиту, був API-ключем
 * користувача.
 */
final class SystemInfoResponseAccounting implements \JsonSerializable
{
    /**
     * Дата й час початку періоду обліку в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     * Приклад: `2016-08-29 09:12:33`.
     *
     * @var string|null
     */
    private $periodStart;

    /**
     * Дата й час кінця періоду обліку в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     * Приклад: `2016-09-29 09:12:33`.
     *
     * @var string|null
     */
    private $periodEnd;

    /**
     * Кількість листів, включених в обліковий період.
     *
     * @var int|null
     */
    private $emailsIncluded;

    /**
     * Кількість листів, надісланих за обліковий період. Може бути більшою за emails_included у разі перевищення.
     *
     * @var int|null
     */
    private $emailsSent;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->periodStart = Data::string($data['period_start'] ?? null);
        $model->periodEnd = Data::string($data['period_end'] ?? null);
        $model->emailsIncluded = Data::int($data['emails_included'] ?? null);
        $model->emailsSent = Data::int($data['emails_sent'] ?? null);

        return $model;
    }

    /**
     * Дата й час початку періоду обліку в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     */
    public function getPeriodStart(): ?string
    {
        return $this->periodStart;
    }

    /**
     * Дата й час початку періоду обліку в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     *
     * @return $this
     */
    public function setPeriodStart(?string $periodStart): self
    {
        $this->periodStart = $periodStart;

        return $this;
    }

    /**
     * Дата й час кінця періоду обліку в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     */
    public function getPeriodEnd(): ?string
    {
        return $this->periodEnd;
    }

    /**
     * Дата й час кінця періоду обліку в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     *
     * @return $this
     */
    public function setPeriodEnd(?string $periodEnd): self
    {
        $this->periodEnd = $periodEnd;

        return $this;
    }

    /**
     * Кількість листів, включених в обліковий період.
     */
    public function getEmailsIncluded(): ?int
    {
        return $this->emailsIncluded;
    }

    /**
     * Кількість листів, включених в обліковий період.
     *
     * @return $this
     */
    public function setEmailsIncluded(?int $emailsIncluded): self
    {
        $this->emailsIncluded = $emailsIncluded;

        return $this;
    }

    /**
     * Кількість листів, надісланих за обліковий період.
     */
    public function getEmailsSent(): ?int
    {
        return $this->emailsSent;
    }

    /**
     * Кількість листів, надісланих за обліковий період.
     *
     * @return $this
     */
    public function setEmailsSent(?int $emailsSent): self
    {
        $this->emailsSent = $emailsSent;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'period_start' => $this->periodStart,
            'period_end' => $this->periodEnd,
            'emails_included' => $this->emailsIncluded,
            'emails_sent' => $this->emailsSent,
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
