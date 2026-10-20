<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete\Model;

use AllyMailer\Client\Data;

/**
 * ObsoleteUnsubscribedSetResponse
 */
final class ObsoleteUnsubscribedSetResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Відписаний email.
     *
     * @var string|null
     */
    private $address;

    /**
     * Подробиці відписки:
     *
     * - "unsubscribed" якщо email було щойно відписано,
     * - "was inactive" якщо він уже був позначений як неактивний і немає сенсу відписувати,
     * - "was unsubscribed" якщо email уже було відписано раніше,
     * - "added and unsubscribed" якщо для цього email не зберігалося жодного більш раннього статусу, тому його було додано й одразу ж відписано.
     * Значення: константи `ObsoleteUnsubscribedSetMessage`.
     *
     * @var string|null
     */
    private $message;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->address = Data::string($data['address'] ?? null);
        $model->message = Data::string($data['message'] ?? null);

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
     * Відписаний email.
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * Відписаний email.
     *
     * @return $this
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Подробиці відписки:
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Подробиці відписки:
     *
     * @param string|null $message Значення: константи `ObsoleteUnsubscribedSetMessage`.
     *
     * @return $this
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'status' => $this->status,
            'address' => $this->address,
            'message' => $this->message,
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
