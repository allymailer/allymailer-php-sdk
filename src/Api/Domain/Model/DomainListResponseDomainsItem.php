<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

use AllyMailer\Client\Data;

/**
 * DomainListResponseDomainsItem
 */
final class DomainListResponseDomainsItem implements \JsonSerializable
{
    public function __construct(
        /**
         * Ім'я домену.
         * Приклад: `example.com`.
         */
        public ?string $domain = null,
        /**
         * Об'єкт, що описує запис перевірки володіння та її статус.
         */
        public ?DomainListResponseDomainsItemVerificationRecord $verificationRecord = null,
        /**
         * Об'єкт, що описує DKIM-запис та її статус.
         */
        public ?DomainListResponseDomainsItemDkim $dkim = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            domain: Data::string($data['domain'] ?? null),
            verificationRecord: Data::model(DomainListResponseDomainsItemVerificationRecord::class, $data['verification-record'] ?? null),
            dkim: Data::model(DomainListResponseDomainsItemDkim::class, $data['dkim'] ?? null),
        );
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
