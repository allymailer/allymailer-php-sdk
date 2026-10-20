<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;

/**
 * ProjectUpdateRequest
 */
final class ProjectUpdateRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Об'єкт із властивостями проєкту.
         */
        public ProjectUpdateObject $project,
        /**
         * Ідентифікатор проєкту, що оновлюється. Проєкт має бути ідентифіковано або цим полем project_id, або полем
         * project_api_key. Ми рекомендуємо використовувати project_id, це безпечніше.
         * Приклад: `1234567890`.
         */
        public ?string $projectId = null,
        /**
         * Необов'язковий API-ключ проєкту, що оновлюється. Проєкт має бути ідентифіковано або полем project_id, або
         * полем project_api_key. Ми рекомендуємо використовувати project_id, це безпечніше.
         * Приклад: `your api_key`.
         */
        public ?string $projectApiKey = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            project: ProjectUpdateObject::fromArray(Data::array($data['project'] ?? null) ?? []),
            projectId: Data::string($data['project_id'] ?? null),
            projectApiKey: Data::string($data['project_api_key'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'project_id' => $this->projectId,
            'project_api_key' => $this->projectApiKey,
            'project' => Data::object($this->project->toArray()),
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
