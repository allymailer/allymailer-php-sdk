<?php

declare(strict_types=1);

namespace AllyMailer\Api\System\Model;

use AllyMailer\Client\Data;

/**
 * SystemInfoResponse
 */
final class SystemInfoResponse implements \JsonSerializable
{
    public function __construct(
        /**
         * Рядок "success".
         * Допустимі значення: `success`.
         */
        public ?string $status = null,
        /**
         * Унікальний ідентифікатор користувача.
         * Приклад: `11344`.
         */
        public ?int $userId = null,
        /**
         * Email користувача.
         */
        public ?string $email = null,
        /**
         * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки. Присутній лише якщо API-ключ,
         * використаний для запиту, був API-ключем проєкту.
         * Приклад: `6123462132634`.
         */
        public ?string $projectId = null,
        /**
         * Назва проєкту, унікальна в межах облікового запису користувача. Присутня лише якщо API-ключ, використаний для
         * запиту, був API-ключем проєкту.
         * Приклад: `Project 1A`.
         */
        public ?string $projectName = null,
        /**
         * Об'єкт із властивостями лічильника листів. Присутній лише якщо API-ключ, використаний для запиту, був
         * API-ключем проєкту.
         */
        public ?ProjectAccountingObject $projectAccounting = null,
        /**
         * Об'єкт з властивостями періоду обліку. Присутній лише якщо API-ключ, використаний для запиту, був API-ключем
         * користувача.
         */
        public ?SystemInfoResponseAccounting $accounting = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            status: Data::string($data['status'] ?? null),
            userId: Data::int($data['user_id'] ?? null),
            email: Data::string($data['email'] ?? null),
            projectId: Data::string($data['project_id'] ?? null),
            projectName: Data::string($data['project_name'] ?? null),
            projectAccounting: Data::model(ProjectAccountingObject::class, $data['project_accounting'] ?? null),
            accounting: Data::model(SystemInfoResponseAccounting::class, $data['accounting'] ?? null),
        );
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
