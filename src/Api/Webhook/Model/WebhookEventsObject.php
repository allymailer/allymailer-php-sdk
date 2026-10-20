<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\EmailStatus;

/**
 * Об'єкт, що описує події, про які потрібно сповіщати.
 */
final class WebhookEventsObject implements \JsonSerializable
{
    /**
     * Якщо присутній, то надсилатимуться сповіщення про спам-блокування. У масиві має бути єдиний елемент із рядком
     * "*".
     *
     * @var list<string>|null
     */
    private $spamBlock;

    /**
     * Якщо присутній, то надсилатимуться сповіщення про зміну статусу email. У масиві перелічуються ті статуси, про
     * які надсилатимуться сповіщення.
     * Значення: константи `EmailStatus`.
     *
     * @var list<string>|null
     */
    private $emailStatus;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->spamBlock = Data::list($data['spam_block'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->emailStatus = Data::list($data['email_status'] ?? null, static function ($item) { return Data::string($item) ?? ''; });

        return $model;
    }

    /**
     * Якщо присутній, то надсилатимуться сповіщення про спам-блокування.
     *
     * @return list<string>|null
     */
    public function getSpamBlock(): ?array
    {
        return $this->spamBlock;
    }

    /**
     * Якщо присутній, то надсилатимуться сповіщення про спам-блокування.
     *
     * @param list<string>|null $spamBlock
     *
     * @return $this
     */
    public function setSpamBlock(?array $spamBlock): self
    {
        $this->spamBlock = $spamBlock;

        return $this;
    }

    /**
     * Якщо присутній, то надсилатимуться сповіщення про зміну статусу email.
     *
     * @return list<string>|null
     */
    public function getEmailStatus(): ?array
    {
        return $this->emailStatus;
    }

    /**
     * Якщо присутній, то надсилатимуться сповіщення про зміну статусу email.
     *
     * @param list<string>|null $emailStatus Значення: константи `EmailStatus`.
     *
     * @return $this
     */
    public function setEmailStatus(?array $emailStatus): self
    {
        $this->emailStatus = $emailStatus;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'spam_block' => $this->spamBlock,
            'email_status' => $this->emailStatus,
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
