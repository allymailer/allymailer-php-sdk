<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;

/**
 * ProjectListRequest
 */
final class ProjectListRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Опціональна можливість указати project_id для включення до списку лише вказаного проєкту.
         * Приклад: `1234567890`.
         */
        public ?string $projectId = null,
        /**
         * Опціональна можливість указати project_api_key для включення до списку лише вказаного проєкту.
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
