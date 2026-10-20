<?php

declare(strict_types=1);

namespace AllyMailer\Api\System\Model;

use AllyMailer\Client\Data;

/**
 * SystemInfoResponse
 */
final class SystemInfoResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Унікальний ідентифікатор користувача.
     * Приклад: `11344`.
     *
     * @var int|null
     */
    private $userId;

    /**
     * Email користувача.
     *
     * @var string|null
     */
    private $email;

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки. Присутній лише якщо API-ключ,
     * використаний для запиту, був API-ключем проєкту.
     * Приклад: `6123462132634`.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача. Присутня лише якщо API-ключ, використаний для
     * запиту, був API-ключем проєкту.
     * Приклад: `Project 1A`.
     *
     * @var string|null
     */
    private $projectName;

    /**
     * Об'єкт із властивостями лічильника листів. Присутній лише якщо API-ключ, використаний для запиту, був
     * API-ключем проєкту.
     *
     * @var ProjectAccountingObject|null
     */
    private $projectAccounting;

    /**
     * Об'єкт з властивостями періоду обліку. Присутній лише якщо API-ключ, використаний для запиту, був API-ключем
     * користувача.
     *
     * @var SystemInfoResponseAccounting|null
     */
    private $accounting;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->userId = Data::int($data['user_id'] ?? null);
        $model->email = Data::string($data['email'] ?? null);
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->projectName = Data::string($data['project_name'] ?? null);
        $model->projectAccounting = Data::model(ProjectAccountingObject::class, $data['project_accounting'] ?? null);
        $model->accounting = Data::model(SystemInfoResponseAccounting::class, $data['accounting'] ?? null);

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
     * Унікальний ідентифікатор користувача.
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * Унікальний ідентифікатор користувача.
     *
     * @return $this
     */
    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Email користувача.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Email користувача.
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
     * Назва проєкту, унікальна в межах облікового запису користувача.
     */
    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     *
     * @return $this
     */
    public function setProjectName(?string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Об'єкт із властивостями лічильника листів.
     */
    public function getProjectAccounting(): ?ProjectAccountingObject
    {
        return $this->projectAccounting;
    }

    /**
     * Об'єкт із властивостями лічильника листів.
     *
     * @return $this
     */
    public function setProjectAccounting(?ProjectAccountingObject $projectAccounting): self
    {
        $this->projectAccounting = $projectAccounting;

        return $this;
    }

    /**
     * Об'єкт з властивостями періоду обліку.
     */
    public function getAccounting(): ?SystemInfoResponseAccounting
    {
        return $this->accounting;
    }

    /**
     * Об'єкт з властивостями періоду обліку.
     *
     * @return $this
     */
    public function setAccounting(?SystemInfoResponseAccounting $accounting): self
    {
        $this->accounting = $accounting;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'user_id' => $this->userId,
            'email' => $this->email,
            'project_id' => $this->projectId,
            'project_name' => $this->projectName,
            'project_accounting' => null === $this->projectAccounting ? null : Data::object($this->projectAccounting->toArray()),
            'accounting' => null === $this->accounting ? null : Data::object($this->accounting->toArray()),
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
