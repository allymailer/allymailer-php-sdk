<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;

/**
 * ProjectDeleteRequest
 */
final class ProjectDeleteRequest implements \JsonSerializable
{
    /**
     * Ідентифікатор проєкту, що видаляється. Проєкт має бути ідентифіковано або цим полем project_id, або полем
     * project_api_key. Ми рекомендуємо використовувати project_id, це безпечніше.
     * Приклад: `1234567890`.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * Необов'язковий API-ключ проєкту, що видаляється. Проєкт має бути ідентифіковано або полем project_id, або
     * полем project_api_key. Ми рекомендуємо використовувати project_id, це безпечніше.
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
     * Ідентифікатор проєкту, що видаляється.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Ідентифікатор проєкту, що видаляється.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Необов'язковий API-ключ проєкту, що видаляється.
     */
    public function getProjectApiKey(): ?string
    {
        return $this->projectApiKey;
    }

    /**
     * Необов'язковий API-ключ проєкту, що видаляється.
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
