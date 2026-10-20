<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт, що описує DKIM-запис та її статус.
 */
final class DomainListResponseDomainsItemDkim implements \JsonSerializable
{
    public function __construct(
        /**
         * DKIM-підпис для домену. У цьому полі повертається лише ключ. Щоб DNS-запис був коректним, перед ключем
         * потрібно додати "k=rsa, p=" (див.
         * [domain/get-dns-records](https://docs.allymailer.com.ua/ua/web-api-ref#domain-get-dns-records)).
         * Приклад: `MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDo7`.
         */
        public ?string $key = null,
        /**
         * Лише домени зі статусом DKIM-запису "active" можуть використовуватися для надсилання листів.
         */
        public DkimStatus|string|null $status = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            key: Data::string($data['key'] ?? null),
            status: Data::enum(DkimStatus::class, Data::string($data['status'] ?? null)),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'key' => $this->key,
            'status' => Data::value($this->status),
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
