<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * Опис формату webhook.
 */
final class WebhookCallback implements \JsonSerializable
{
    public function __construct(
        /**
         * MD5-хеш рядкового тіла повідомлення, у якому значення auth замінено на api_key користувача/проєкту, чий
         * обробник викликається. За допомогою цього отримувач сповіщення може як провести автентифікацію, так і
         * перевірити цілісність сповіщення.
         */
        public ?string $auth = null,
        /**
         * Масив з одним елементом, що містить дані про події користувача/проєкту.
         * @var list<WebhookCallbackEventsByUserItem>|null
         */
        public ?array $eventsByUser = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            auth: Data::string($data['auth'] ?? null),
            eventsByUser: Data::list($data['events_by_user'] ?? null, static fn ($item) => WebhookCallbackEventsByUserItem::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'auth' => $this->auth,
            'events_by_user' => null === $this->eventsByUser ? null : \array_map(static fn (WebhookCallbackEventsByUserItem $item) => Data::object($item->toArray()), $this->eventsByUser),
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
