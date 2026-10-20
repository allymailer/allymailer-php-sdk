<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\EmailStatus;

/**
 * Об'єкт, що описує події, про які потрібно сповіщати.
 */
final class WebhookEventsObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Якщо присутній, то надсилатимуться сповіщення про спам-блокування. У масиві має бути єдиний елемент із рядком
         * "*".
         * @var list<string>|null
         */
        public ?array $spamBlock = null,
        /**
         * Якщо присутній, то надсилатимуться сповіщення про зміну статусу email. У масиві перелічуються ті статуси, про
         * які надсилатимуться сповіщення.
         * @var list<EmailStatus|string>|null
         */
        public ?array $emailStatus = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            spamBlock: Data::list($data['spam_block'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            emailStatus: Data::list($data['email_status'] ?? null, static fn ($item) => Data::enum(EmailStatus::class, Data::string($item) ?? '')),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'spam_block' => $this->spamBlock,
            'email_status' => Data::value($this->emailStatus),
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
