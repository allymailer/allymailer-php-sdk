<?php

declare(strict_types=1);

namespace AllyMailer\Api\Email\Model;

use AllyMailer\Client\Data;

/**
 * EmailSubscribeRequest
 */
final class EmailSubscribeRequest implements \JsonSerializable
{
    /**
     * Адреса відправника на підтвердженому домені. (Також підтримується іменування поля як "email_address_from").
     * Приклад: `email@example.com`.
     *
     * @var string
     */
    private $fromEmail;

    /**
     * Ім'я відправника. (Також підтримується іменування поля як "name_from").
     * Приклад: `Example`.
     *
     * @var string
     */
    private $fromName;

    /**
     * Адреса отримувача. (Також підтримується іменування поля як "email_address_to").
     * Приклад: `email@example.com`.
     *
     * @var string
     */
    private $toEmail;

    public function __construct(string $fromEmail, string $fromName, string $toEmail)
    {
        $this->fromEmail = $fromEmail;
        $this->fromName = $fromName;
        $this->toEmail = $toEmail;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data['from_email'] ?? null) ?? '',
            Data::string($data['from_name'] ?? null) ?? '',
            Data::string($data['to_email'] ?? null) ?? ''
        );
    }

    /**
     * Адреса відправника на підтвердженому домені. (Також підтримується іменування поля як "email_address_from").
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * Адреса відправника на підтвердженому домені. (Також підтримується іменування поля як "email_address_from").
     *
     * @return $this
     */
    public function setFromEmail(string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Ім'я відправника. (Також підтримується іменування поля як "name_from").
     */
    public function getFromName(): string
    {
        return $this->fromName;
    }

    /**
     * Ім'я відправника. (Також підтримується іменування поля як "name_from").
     *
     * @return $this
     */
    public function setFromName(string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Адреса отримувача. (Також підтримується іменування поля як "email_address_to").
     */
    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    /**
     * Адреса отримувача. (Також підтримується іменування поля як "email_address_to").
     *
     * @return $this
     */
    public function setToEmail(string $toEmail): self
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'from_email' => $this->fromEmail,
            'from_name' => $this->fromName,
            'to_email' => $this->toEmail,
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
