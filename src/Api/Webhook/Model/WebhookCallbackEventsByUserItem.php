<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * WebhookCallbackEventsByUserItem
 */
final class WebhookCallbackEventsByUserItem implements \JsonSerializable
{
    /**
     * Унікальний ідентифікатор користувача.
     * Приклад: `11344`.
     *
     * @var int|null
     */
    private $userId;

    /**
     * Ідентифікатор проєкту, присутній, якщо webhook було зареєстровано за допомогою API-ключа проєкту.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * Назва проєкту, присутня, якщо webhook було зареєстровано за допомогою API-ключа проєкту.
     *
     * @var string|null
     */
    private $projectName;

    /**
     * Масив подій, про які сповіщає виклик webhook.
     *
     * @var list<WebhookCallbackEventsByUserItemEventsItem>|null
     */
    private $events;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->userId = Data::int($data['user_id'] ?? null);
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->projectName = Data::string($data['project_name'] ?? null);
        $model->events = Data::list($data['events'] ?? null, static function ($item) { return WebhookCallbackEventsByUserItemEventsItem::fromArray(Data::array($item) ?? []); });

        return $model;
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
     * Ідентифікатор проєкту, присутній, якщо webhook було зареєстровано за допомогою API-ключа проєкту.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Ідентифікатор проєкту, присутній, якщо webhook було зареєстровано за допомогою API-ключа проєкту.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Назва проєкту, присутня, якщо webhook було зареєстровано за допомогою API-ключа проєкту.
     */
    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    /**
     * Назва проєкту, присутня, якщо webhook було зареєстровано за допомогою API-ключа проєкту.
     *
     * @return $this
     */
    public function setProjectName(?string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Масив подій, про які сповіщає виклик webhook.
     *
     * @return list<WebhookCallbackEventsByUserItemEventsItem>|null
     */
    public function getEvents(): ?array
    {
        return $this->events;
    }

    /**
     * Масив подій, про які сповіщає виклик webhook.
     *
     * @param list<WebhookCallbackEventsByUserItemEventsItem>|null $events
     *
     * @return $this
     */
    public function setEvents(?array $events): self
    {
        $this->events = $events;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'user_id' => $this->userId,
            'project_id' => $this->projectId,
            'project_name' => $this->projectName,
            'events' => null === $this->events ? null : \array_map(static function (WebhookCallbackEventsByUserItemEventsItem $item) { return Data::object($item->toArray()); }, $this->events),
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
