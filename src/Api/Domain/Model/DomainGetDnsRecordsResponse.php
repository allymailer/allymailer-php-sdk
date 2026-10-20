<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

use AllyMailer\Client\Data;

/**
 * DomainGetDnsRecordsResponse
 */
final class DomainGetDnsRecordsResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Домен, для якого потрібно отримати інформацію про DNS-записи.
         * Приклад: `example.com`.
         */
        public ?string $domain = null,
        /**
         * Запис, який потрібно внести "як є" для підтвердження володіння цим доменом.
         * Приклад: `allymailer-validate-hash=483bb362ebdbeedd755cfb1d4d661`.
         */
        public ?string $verificationRecord = null,
        /**
         * DKIM-підпис для домену. У цьому полі повертається лише ключ. Щоб TXT-запис був коректним, перед ключем
         * потрібно додати "v=DKIM1; k=rsa; p=".
         * Приклад: `MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDo7`.
         */
        public ?string $dkim = null,
        /**
         * Значення CNAME-запису для хоста "_dmarc" домену.
         * Приклад: `example.com.dmarc.allymailer.com.ua.`.
         */
        public ?string $dmarc = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            domain: Data::string($data['domain'] ?? null),
            verificationRecord: Data::string($data['verification-record'] ?? null),
            dkim: Data::string($data['dkim'] ?? null),
            dmarc: Data::string($data['dmarc'] ?? null),
        );
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
