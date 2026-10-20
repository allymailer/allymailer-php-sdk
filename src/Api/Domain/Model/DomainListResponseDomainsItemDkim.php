<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт, що описує DKIM-запис та її статус.
 */
final class DomainListResponseDomainsItemDkim implements \JsonSerializable
{
    /**
     * DKIM-підпис для домену. У цьому полі повертається лише ключ. Щоб DNS-запис був коректним, перед ключем
     * потрібно додати "k=rsa, p=" (див.
     * [domain/get-dns-records](https://docs.allymailer.com.ua/ua/web-api-ref#domain-get-dns-records)).
     * Приклад: `MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDo7`.
     *
     * @var string|null
     */
    private $key;

    /**
     * Лише домени зі статусом DKIM-запису "active" можуть використовуватися для надсилання листів.
     * Значення: константи `DkimStatus`.
     *
     * @var string|null
     */
    private $status;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->key = Data::string($data['key'] ?? null);
        $model->status = Data::string($data['status'] ?? null);

        return $model;
    }

    /**
     * DKIM-підпис для домену.
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * DKIM-підпис для домену.
     *
     * @return $this
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Лише домени зі статусом DKIM-запису "active" можуть використовуватися для надсилання листів.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Лише домени зі статусом DKIM-запису "active" можуть використовуватися для надсилання листів.
     *
     * @param string|null $status Значення: константи `DkimStatus`.
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'key' => $this->key,
            'status' => $this->status,
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
