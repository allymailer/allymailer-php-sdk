<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project\Model;

use AllyMailer\Client\Data;

/**
 * ProjectListResponse
 */
final class ProjectListResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Масив об'єктів, де кожен об'єкт відповідає окремому проєкту.
     *
     * @var list<ProjectListObject>|null
     */
    private $projects;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->projects = Data::list($data['projects'] ?? null, static function ($item) { return ProjectListObject::fromArray(Data::array($item) ?? []); });

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
     * Масив об'єктів, де кожен об'єкт відповідає окремому проєкту.
     *
     * @return list<ProjectListObject>|null
     */
    public function getProjects(): ?array
    {
        return $this->projects;
    }

    /**
     * Масив об'єктів, де кожен об'єкт відповідає окремому проєкту.
     *
     * @param list<ProjectListObject>|null $projects
     *
     * @return $this
     */
    public function setProjects(?array $projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'projects' => null === $this->projects ? null : \array_map(static function (ProjectListObject $item) { return Data::object($item->toArray()); }, $this->projects),
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
