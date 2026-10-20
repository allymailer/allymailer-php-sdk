<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * WebhookCallbackEventsByUserItem
 */
final class WebhookCallbackEventsByUserItem implements \JsonSerializable
{
    public function __construct(
        /**
         * Унікальний ідентифікатор користувача.
         * Приклад: `11344`.
         */
        public ?int $userId = null,
        /**
         * Ідентифікатор проєкту, присутній, якщо webhook було зареєстровано за допомогою API-ключа проєкту.
         */
        public ?string $projectId = null,
        /**
         * Назва проєкту, присутня, якщо webhook було зареєстровано за допомогою API-ключа проєкту.
         */
        public ?string $projectName = null,
        /**
         * Масив подій, про які сповіщає виклик webhook.
         * @var list<WebhookCallbackEventsByUserItemEventsItem>|null
         */
        public ?array $events = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            userId: Data::int($data['user_id'] ?? null),
            projectId: Data::string($data['project_id'] ?? null),
            projectName: Data::string($data['project_name'] ?? null),
            events: Data::list($data['events'] ?? null, static fn ($item) => WebhookCallbackEventsByUserItemEventsItem::fromArray(Data::array($item) ?? [])),
        );
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
            'events' => null === $this->events ? null : \array_map(static fn (WebhookCallbackEventsByUserItemEventsItem $item) => Data::object($item->toArray()), $this->events),
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
