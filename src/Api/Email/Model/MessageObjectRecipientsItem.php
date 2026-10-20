<?php

declare(strict_types=1);

namespace AllyMailer\Api\Email\Model;

use AllyMailer\Client\Data;

/**
 * MessageObjectRecipientsItem
 */
final class MessageObjectRecipientsItem implements \JsonSerializable
{
    public function __construct(
        /**
         * Email-адреса отримувача
         */
        public string $email,
        /**
         * Об'єкт, що описує підстановки для конкретного отримувача (наприклад, ім'я, товар для показу саме цьому
         * отримувачу — див. [Шаблонізатори](https://docs.allymailer.com.ua/en/template-engines)). Підстановки працюють у
         * параметрах:
         *
         * - body.html
         * - body.plaintext
         * - body.amp
         * - subject
         * - from_name
         * - headers["List-Unsubscribe"]
         * - options.unsubscribe_url
         * Назви змінних можуть містити літери латинського алфавіту, цифри, символ "_". Першим символом може бути лише
         * літера, використання пробілів не допускається. Є спеціальна змінна "to_name", що дозволяє задати ім'я
         * отримувача. У разі підстановки туди "Ім'я Прізвище" SMTP-заголовок “To” виглядатиме як "Ім'я Прізвище
         * <email@example.com>". Довжина змінної "to_name" обмежена 78 символами.
         * @var array<string, string>|null
         */
        public ?array $substitutions = null,
        /**
         * Об'єкт для передачі метаданих, специфічних для окремого отримувача, де "key" — рядок до 64 символів завдовжки,
         * "value" — рядок до 1024 символів завдовжки, максимальна кількість ключів — 10. Метадані передаються під час
         * виклику [webhook](https://docs.allymailer.com.ua/ua/web-api-ref#webhook) і методів
         * [event-dump](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump). Для групування листів в одну розсилку
         * може використовуватися системний ключ "campaign_id" зі значенням у вигляді невід'ємного десяткового цілого або
         * UUID до 128 біт.
         * @var array<string, string>|null
         */
        public ?array $metadata = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            email: Data::string($data['email'] ?? null) ?? '',
            substitutions: Data::map($data['substitutions'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            metadata: Data::map($data['metadata'] ?? null, static fn ($item) => Data::string($item) ?? ''),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'email' => $this->email,
            'substitutions' => Data::object($this->substitutions),
            'metadata' => Data::object($this->metadata),
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
