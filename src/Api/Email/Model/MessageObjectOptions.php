<?php

declare(strict_types=1);

namespace AllyMailer\Api\Email\Model;

use AllyMailer\Client\Data;

/**
 * Додаткові опції.
 */
final class MessageObjectOptions implements \JsonSerializable
{
    /**
     * Дата й час у форматі "РРРР-ММ-ДД гг:хх:сс" у часовому поясі UTC. Дозволяє запланувати час надсилання на
     * майбутнє, у межах 24 годин від поточного часу.
     * Приклад: `2021-11-19 10:00:00`.
     *
     * @var string|null
     */
    private $sendAt;

    /**
     * Користувацьке посилання відписки. Докладніше [тут](https://docs.allymailer.com.ua/unsubscribe-link).
     * Приклад: `https://example.org/unsubscribe/&#7b;&#7b;CustomerId&#7c;&#7c;`.
     *
     * @var string|null
     */
    private $unsubscribeUrl;

    /**
     * Ідентифікатор backend-домену, через який надсилається повідомлення. Якщо відсутній — надсилання буде від імені
     * backend-домену, призначеного вашому обліковому запису/проєкту за замовчуванням. Ви можете придбати один або
     * декілька виділених IP-адрес і використовувати цю опцію для вибору.
     *
     * @var int|null
     */
    private $customBackendId;

    /**
     * Ідентифікатор пулу SMTP, через який надсилається повідомлення. Зазвичай немає необхідності вказувати пул явно,
     * оскільки він обирається автоматично або як пул за замовчуванням для вашого облікового запису/проєкту, або
     * відповідно до переданого параметра custom_backend_id.
     *
     * @var string|null
     */
    private $smtpPoolId;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->sendAt = Data::string($data['send_at'] ?? null);
        $model->unsubscribeUrl = Data::string($data['unsubscribe_url'] ?? null);
        $model->customBackendId = Data::int($data['custom_backend_id'] ?? null);
        $model->smtpPoolId = Data::string($data['smtp_pool_id'] ?? null);

        return $model;
    }

    /**
     * Дата й час у форматі "РРРР-ММ-ДД гг:хх:сс" у часовому поясі UTC.
     */
    public function getSendAt(): ?string
    {
        return $this->sendAt;
    }

    /**
     * Дата й час у форматі "РРРР-ММ-ДД гг:хх:сс" у часовому поясі UTC.
     *
     * @return $this
     */
    public function setSendAt(?string $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    /**
     * Користувацьке посилання відписки.
     */
    public function getUnsubscribeUrl(): ?string
    {
        return $this->unsubscribeUrl;
    }

    /**
     * Користувацьке посилання відписки.
     *
     * @return $this
     */
    public function setUnsubscribeUrl(?string $unsubscribeUrl): self
    {
        $this->unsubscribeUrl = $unsubscribeUrl;

        return $this;
    }

    /**
     * Ідентифікатор backend-домену, через який надсилається повідомлення.
     */
    public function getCustomBackendId(): ?int
    {
        return $this->customBackendId;
    }

    /**
     * Ідентифікатор backend-домену, через який надсилається повідомлення.
     *
     * @return $this
     */
    public function setCustomBackendId(?int $customBackendId): self
    {
        $this->customBackendId = $customBackendId;

        return $this;
    }

    /**
     * Ідентифікатор пулу SMTP, через який надсилається повідомлення.
     */
    public function getSmtpPoolId(): ?string
    {
        return $this->smtpPoolId;
    }

    /**
     * Ідентифікатор пулу SMTP, через який надсилається повідомлення.
     *
     * @return $this
     */
    public function setSmtpPoolId(?string $smtpPoolId): self
    {
        $this->smtpPoolId = $smtpPoolId;

        return $this;
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
