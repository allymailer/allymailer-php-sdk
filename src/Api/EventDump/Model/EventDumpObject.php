<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт із властивостями дампа подій.
 */
final class EventDumpObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Ідентифікатор дампа, отриманий методом
         * [event-dump/create](https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-create).
         * Приклад: `Gqfasjh34tlasd`.
         */
        public ?string $dumpId = null,
        /**
         * Статус задачі. Одне з чотирьох значень:
         *
         * - __queued__ - очікує в черзі, обробка ще не починалася;
         * - __in_process__ - триває обробка;
         * - __ready__ - обробку завершено, файли доступні для завантаження;
         * - __failed__ - обробку перервано з помилкою.
         * Приклад: `in_process`.
         */
        public ?string $dumpStatus = null,
        /**
         * Масив об'єктів, кожен з яких позначає готовий до завантаження файл. Навіть якщо "dump_status"="in_process",
         * уже можна завантажувати ті файли, які вказані в "files". У разі відсутності подій за заданими параметрами буде
         * повернуто порожній масив.
         * @var list<EventDumpFilesObject>|null
         */
        public ?array $files = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            dumpId: Data::string($data['dump_id'] ?? null),
            dumpStatus: Data::string($data['dump_status'] ?? null),
            files: Data::list($data['files'] ?? null, static fn ($item) => EventDumpFilesObject::fromArray(Data::array($item) ?? [])),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'dump_id' => $this->dumpId,
            'dump_status' => $this->dumpStatus,
            'files' => null === $this->files ? null : \array_map(static fn (EventDumpFilesObject $item) => Data::object($item->toArray()), $this->files),
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
