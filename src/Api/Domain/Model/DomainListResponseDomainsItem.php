<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

use AllyMailer\Client\Data;

/**
 * DomainListResponseDomainsItem
 */
final class DomainListResponseDomainsItem implements \JsonSerializable
{
    /**
     * Ім'я домену.
     * Приклад: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Об'єкт, що описує запис перевірки володіння та її статус.
     *
     * @var DomainListResponseDomainsItemVerificationRecord|null
     */
    private $verificationRecord;

    /**
     * Об'єкт, що описує DKIM-запис та її статус.
     *
     * @var DomainListResponseDomainsItemDkim|null
     */
    private $dkim;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->domain = Data::string($data['domain'] ?? null);
        $model->verificationRecord = Data::model(DomainListResponseDomainsItemVerificationRecord::class, $data['verification-record'] ?? null);
        $model->dkim = Data::model(DomainListResponseDomainsItemDkim::class, $data['dkim'] ?? null);

        return $model;
    }

    /**
     * Ім'я домену.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Ім'я домену.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Об'єкт, що описує запис перевірки володіння та її статус.
     */
    public function getVerificationRecord(): ?DomainListResponseDomainsItemVerificationRecord
    {
        return $this->verificationRecord;
    }

    /**
     * Об'єкт, що описує запис перевірки володіння та її статус.
     *
     * @return $this
     */
    public function setVerificationRecord(?DomainListResponseDomainsItemVerificationRecord $verificationRecord): self
    {
        $this->verificationRecord = $verificationRecord;

        return $this;
    }

    /**
     * Об'єкт, що описує DKIM-запис та її статус.
     */
    public function getDkim(): ?DomainListResponseDomainsItemDkim
    {
        return $this->dkim;
    }

    /**
     * Об'єкт, що описує DKIM-запис та її статус.
     *
     * @return $this
     */
    public function setDkim(?DomainListResponseDomainsItemDkim $dkim): self
    {
        $this->dkim = $dkim;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'domain' => $this->domain,
            'verification-record' => null === $this->verificationRecord ? null : Data::object($this->verificationRecord->toArray()),
            'dkim' => null === $this->dkim ? null : Data::object($this->dkim->toArray()),
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
