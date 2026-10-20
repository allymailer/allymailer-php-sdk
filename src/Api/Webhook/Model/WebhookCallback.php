<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * Опис формату webhook.
 */
final class WebhookCallback implements \JsonSerializable
{
    /**
     * MD5-хеш рядкового тіла повідомлення, у якому значення auth замінено на api_key користувача/проєкту, чий
     * обробник викликається. За допомогою цього отримувач сповіщення може як провести автентифікацію, так і
     * перевірити цілісність сповіщення.
     *
     * @var string|null
     */
    private $auth;

    /**
     * Масив з одним елементом, що містить дані про події користувача/проєкту.
     *
     * @var list<WebhookCallbackEventsByUserItem>|null
     */
    private $eventsByUser;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->auth = Data::string($data['auth'] ?? null);
        $model->eventsByUser = Data::list($data['events_by_user'] ?? null, static function ($item) { return WebhookCallbackEventsByUserItem::fromArray(Data::array($item) ?? []); });

        return $model;
    }

    /**
     * MD5-хеш рядкового тіла повідомлення, у якому значення auth замінено на api_key користувача/проєкту, чий
     * обробник викликається.
     */
    public function getAuth(): ?string
    {
        return $this->auth;
    }

    /**
     * MD5-хеш рядкового тіла повідомлення, у якому значення auth замінено на api_key користувача/проєкту, чий
     * обробник викликається.
     *
     * @return $this
     */
    public function setAuth(?string $auth): self
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * Масив з одним елементом, що містить дані про події користувача/проєкту.
     *
     * @return list<WebhookCallbackEventsByUserItem>|null
     */
    public function getEventsByUser(): ?array
    {
        return $this->eventsByUser;
    }

    /**
     * Масив з одним елементом, що містить дані про події користувача/проєкту.
     *
     * @param list<WebhookCallbackEventsByUserItem>|null $eventsByUser
     *
     * @return $this
     */
    public function setEventsByUser(?array $eventsByUser): self
    {
        $this->eventsByUser = $eventsByUser;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'auth' => $this->auth,
            'events_by_user' => null === $this->eventsByUser ? null : \array_map(static function (WebhookCallbackEventsByUserItem $item) { return Data::object($item->toArray()); }, $this->eventsByUser),
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
