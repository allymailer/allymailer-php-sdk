<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;

/**
 * ProjectCreateResponse
 */
final class ProjectCreateResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     * Приклад: `6123462132634`.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * API-ключ проєкту. Ви можете використовувати цей ключ замість користувацького api_key у всіх методах, крім
     * project-методів.
     *
     * @var string|null
     */
    private $projectApiKey;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->projectApiKey = Data::string($data['project_api_key'] ?? null);

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
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * API-ключ проєкту.
     */
    public function getProjectApiKey(): ?string
    {
        return $this->projectApiKey;
    }

    /**
     * API-ключ проєкту.
     *
     * @return $this
     */
    public function setProjectApiKey(?string $projectApiKey): self
    {
        $this->projectApiKey = $projectApiKey;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'project_id' => $this->projectId,
            'project_api_key' => $this->projectApiKey,
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
