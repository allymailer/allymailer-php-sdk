<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;

/**
 * ProjectListRequest
 */
final class ProjectListRequest implements \JsonSerializable
{
    /**
     * Опціональна можливість указати project_id для включення до списку лише вказаного проєкту.
     * Приклад: `1234567890`.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * Опціональна можливість указати project_api_key для включення до списку лише вказаного проєкту.
     * Приклад: `your api_key`.
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
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->projectApiKey = Data::string($data['project_api_key'] ?? null);

        return $model;
    }

    /**
     * Опціональна можливість указати project_id для включення до списку лише вказаного проєкту.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Опціональна можливість указати project_id для включення до списку лише вказаного проєкту.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Опціональна можливість указати project_api_key для включення до списку лише вказаного проєкту.
     */
    public function getProjectApiKey(): ?string
    {
        return $this->projectApiKey;
    }

    /**
     * Опціональна можливість указати project_api_key для включення до списку лише вказаного проєкту.
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
