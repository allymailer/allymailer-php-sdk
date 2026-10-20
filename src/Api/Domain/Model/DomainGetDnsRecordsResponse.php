<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

use AllyMailer\Client\Data;

/**
 * DomainGetDnsRecordsResponse
 */
final class DomainGetDnsRecordsResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Домен, для якого потрібно отримати інформацію про DNS-записи.
     * Приклад: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Запис, який потрібно внести "як є" для підтвердження володіння цим доменом.
     * Приклад: `allymailer-validate-hash=483bb362ebdbeedd755cfb1d4d661`.
     *
     * @var string|null
     */
    private $verificationRecord;

    /**
     * DKIM-підпис для домену. У цьому полі повертається лише ключ. Щоб TXT-запис був коректним, перед ключем
     * потрібно додати "v=DKIM1; k=rsa; p=".
     * Приклад: `MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDo7`.
     *
     * @var string|null
     */
    private $dkim;

    /**
     * Значення CNAME-запису для хоста "_dmarc" домену.
     * Приклад: `example.com.dmarc.allymailer.com.ua.`.
     *
     * @var string|null
     */
    private $dmarc;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->domain = Data::string($data['domain'] ?? null);
        $model->verificationRecord = Data::string($data['verification-record'] ?? null);
        $model->dkim = Data::string($data['dkim'] ?? null);
        $model->dmarc = Data::string($data['dmarc'] ?? null);

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
     * Домен, для якого потрібно отримати інформацію про DNS-записи.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Домен, для якого потрібно отримати інформацію про DNS-записи.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Запис, який потрібно внести "як є" для підтвердження володіння цим доменом.
     */
    public function getVerificationRecord(): ?string
    {
        return $this->verificationRecord;
    }

    /**
     * Запис, який потрібно внести "як є" для підтвердження володіння цим доменом.
     *
     * @return $this
     */
    public function setVerificationRecord(?string $verificationRecord): self
    {
        $this->verificationRecord = $verificationRecord;

        return $this;
    }

    /**
     * DKIM-підпис для домену.
     */
    public function getDkim(): ?string
    {
        return $this->dkim;
    }

    /**
     * DKIM-підпис для домену.
     *
     * @return $this
     */
    public function setDkim(?string $dkim): self
    {
        $this->dkim = $dkim;

        return $this;
    }

    /**
     * Значення CNAME-запису для хоста "_dmarc" домену.
     */
    public function getDmarc(): ?string
    {
        return $this->dmarc;
    }

    /**
     * Значення CNAME-запису для хоста "_dmarc" домену.
     *
     * @return $this
     */
    public function setDmarc(?string $dmarc): self
    {
        $this->dmarc = $dmarc;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'domain' => $this->domain,
            'verification-record' => $this->verificationRecord,
            'dkim' => $this->dkim,
            'dmarc' => $this->dmarc,
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
