<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;

/**
 * ProjectCreateRequest
 */
final class ProjectCreateRequest implements \JsonSerializable
{
    /**
     * Об'єкт із властивостями проєкту.
     *
     * @var ProjectObject
     */
    private $project;

    public function __construct(ProjectObject $project)
    {
        $this->project = $project;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(ProjectObject::fromArray(Data::array($data['project'] ?? null) ?? []));
    }

    /**
     * Об'єкт із властивостями проєкту.
     */
    public function getProject(): ProjectObject
    {
        return $this->project;
    }

    /**
     * Об'єкт із властивостями проєкту.
     *
     * @return $this
     */
    public function setProject(ProjectObject $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'project' => Data::object($this->project->toArray()),
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
