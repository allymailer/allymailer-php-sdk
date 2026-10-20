<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression\Model;

use AllyMailer\Client\Data;

/**
 * SuppressionGetRequest
 */
final class SuppressionGetRequest implements \JsonSerializable
{
    /**
     * Email-адреса, для якої потрібно отримати дані про недоступність.
     * Приклад: `email@example.com`.
     *
     * @var string
     */
    private $email;

    /**
     * Якщо у користувача увімкнено проєкти, all_projects=true дозволить шукати за даними всіх проєктів.
     * За замовчуванням: `False`.
     *
     * @var bool|null
     */
    private $allProjects;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(Data::string($data['email'] ?? null) ?? '');
        $model->allProjects = Data::bool($data['all_projects'] ?? null);

        return $model;
    }

    /**
     * Email-адреса, для якої потрібно отримати дані про недоступність.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Email-адреса, для якої потрібно отримати дані про недоступність.
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Якщо у користувача увімкнено проєкти, all_projects=true дозволить шукати за даними всіх проєктів.
     */
    public function getAllProjects(): ?bool
    {
        return $this->allProjects;
    }

    /**
     * Якщо у користувача увімкнено проєкти, all_projects=true дозволить шукати за даними всіх проєктів.
     *
     * @return $this
     */
    public function setAllProjects(?bool $allProjects): self
    {
        $this->allProjects = $allProjects;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
            'all_projects' => $this->allProjects,
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
