<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт із властивостями дампа подій.
 */
final class EventDumpObject implements \JsonSerializable
{
    /**
     * Ідентифікатор дампа, отриманий методом
     * [event-dump/create](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-create).
     * Приклад: `Gqfasjh34tlasd`.
     *
     * @var string|null
     */
    private $dumpId;

    /**
     * Статус задачі. Одне з чотирьох значень:
     *
     * - __queued__ - очікує в черзі, обробка ще не починалася;
     * - __in_process__ - триває обробка;
     * - __ready__ - обробку завершено, файли доступні для завантаження;
     * - __failed__ - обробку перервано з помилкою.
     * Приклад: `in_process`.
     *
     * @var string|null
     */
    private $dumpStatus;

    /**
     * Масив об'єктів, кожен з яких позначає готовий до завантаження файл. Навіть якщо "dump_status"="in_process",
     * уже можна завантажувати ті файли, які вказані в "files". У разі відсутності подій за заданими параметрами буде
     * повернуто порожній масив.
     *
     * @var list<EventDumpFilesObject>|null
     */
    private $files;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->dumpId = Data::string($data['dump_id'] ?? null);
        $model->dumpStatus = Data::string($data['dump_status'] ?? null);
        $model->files = Data::list($data['files'] ?? null, static function ($item) { return EventDumpFilesObject::fromArray(Data::array($item) ?? []); });

        return $model;
    }

    /**
     * Ідентифікатор дампа, отриманий методом
     * [event-dump/create](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-create).
     */
    public function getDumpId(): ?string
    {
        return $this->dumpId;
    }

    /**
     * Ідентифікатор дампа, отриманий методом
     * [event-dump/create](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-create).
     *
     * @return $this
     */
    public function setDumpId(?string $dumpId): self
    {
        $this->dumpId = $dumpId;

        return $this;
    }

    /**
     * Статус задачі.
     */
    public function getDumpStatus(): ?string
    {
        return $this->dumpStatus;
    }

    /**
     * Статус задачі.
     *
     * @return $this
     */
    public function setDumpStatus(?string $dumpStatus): self
    {
        $this->dumpStatus = $dumpStatus;

        return $this;
    }

    /**
     * Масив об'єктів, кожен з яких позначає готовий до завантаження файл.
     *
     * @return list<EventDumpFilesObject>|null
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    /**
     * Масив об'єктів, кожен з яких позначає готовий до завантаження файл.
     *
     * @param list<EventDumpFilesObject>|null $files
     *
     * @return $this
     */
    public function setFiles(?array $files): self
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'dump_id' => $this->dumpId,
            'dump_status' => $this->dumpStatus,
            'files' => null === $this->files ? null : \array_map(static function (EventDumpFilesObject $item) { return Data::object($item->toArray()); }, $this->files),
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
