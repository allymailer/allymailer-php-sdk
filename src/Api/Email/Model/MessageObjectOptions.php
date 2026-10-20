<?php

declare(strict_types=1);

namespace AllyMailer\Api\Email\Model;

use AllyMailer\Client\Data;

/**
 * Додаткові опції.
 */
final class MessageObjectOptions implements \JsonSerializable
{
    public function __construct(
        /**
         * Дата й час у форматі "РРРР-ММ-ДД гг:хх:сс" у часовому поясі UTC. Дозволяє запланувати час надсилання на
         * майбутнє, у межах 24 годин від поточного часу.
         * Приклад: `2021-11-19 10:00:00`.
         */
        public ?string $sendAt = null,
        /**
         * Користувацьке посилання відписки. Докладніше [тут](https://docs.allymailer.com.ua/unsubscribe-link).
         * Приклад: `https://example.org/unsubscribe/&#7b;&#7b;CustomerId&#7c;&#7c;`.
         */
        public ?string $unsubscribeUrl = null,
        /**
         * Ідентифікатор backend-домену, через який надсилається повідомлення. Якщо відсутній — надсилання буде від імені
         * backend-домену, призначеного вашому обліковому запису/проєкту за замовчуванням. Ви можете придбати один або
         * декілька виділених IP-адрес і використовувати цю опцію для вибору.
         */
        public ?int $customBackendId = null,
        /**
         * Ідентифікатор пулу SMTP, через який надсилається повідомлення. Зазвичай немає необхідності вказувати пул явно,
         * оскільки він обирається автоматично або як пул за замовчуванням для вашого облікового запису/проєкту, або
         * відповідно до переданого параметра custom_backend_id.
         */
        public ?string $smtpPoolId = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            sendAt: Data::string($data['send_at'] ?? null),
            unsubscribeUrl: Data::string($data['unsubscribe_url'] ?? null),
            customBackendId: Data::int($data['custom_backend_id'] ?? null),
            smtpPoolId: Data::string($data['smtp_pool_id'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'send_at' => $this->sendAt,
            'unsubscribe_url' => $this->unsubscribeUrl,
            'custom_backend_id' => $this->customBackendId,
            'smtp_pool_id' => $this->smtpPoolId,
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
