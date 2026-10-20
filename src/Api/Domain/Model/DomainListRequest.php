<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

use AllyMailer\Client\Data;

/**
 * DomainListRequest
 */
final class DomainListRequest implements \JsonSerializable
{
    /**
     * Опціональне ім'я домену, якщо вам потрібно отримати статуси лише за одним доменом.
     * Приклад: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Максимальна кількість доменів, що повертаються. За замовчуванням 50.
     * За замовчуванням: `50`.
     *
     * @var int|null
     */
    private $limit;

    /**
     * Індекс першого домену зі списку, що повертається, рахуючи з нуля.
     * За замовчуванням: `0`.
     *
     * @var int|null
     */
    private $offset;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->domain = Data::string($data['domain'] ?? null);
        $model->limit = Data::int($data['limit'] ?? null);
        $model->offset = Data::int($data['offset'] ?? null);

        return $model;
    }

    /**
     * Опціональне ім'я домену, якщо вам потрібно отримати статуси лише за одним доменом.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Опціональне ім'я домену, якщо вам потрібно отримати статуси лише за одним доменом.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Максимальна кількість доменів, що повертаються.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Максимальна кількість доменів, що повертаються.
     *
     * @return $this
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Індекс першого домену зі списку, що повертається, рахуючи з нуля.
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * Індекс першого домену зі списку, що повертається, рахуючи з нуля.
     *
     * @return $this
     */
    public function setOffset(?int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'domain' => $this->domain,
            'limit' => $this->limit,
            'offset' => $this->offset,
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
