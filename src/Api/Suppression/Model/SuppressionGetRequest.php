<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * SuppressionGetRequest
 */
final class SuppressionGetRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Email-адреса, для якої потрібно отримати дані про недоступність.
         * Приклад: `email@example.com`.
         */
        public string $email,
        /**
         * Якщо у користувача увімкнено проєкти, all_projects=true дозволить шукати за даними всіх проєктів.
         * За замовчуванням: `False`.
         */
        public ?bool $allProjects = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: Data::string($data['email'] ?? null) ?? '',
            allProjects: Data::bool($data['all_projects'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
            'all_projects' => $this->allProjects,
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
