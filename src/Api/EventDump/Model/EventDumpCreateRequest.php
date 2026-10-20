<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * EventDumpCreateRequest
 */
final class EventDumpCreateRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Дата й час у форматі РРРР-ММ-ДД гг:хх:сс, починаючи з якої необхідно отримати події. Дані зберігаються до 45
         * днів, залежно від вашого тарифу.
         * Приклад: `2022-07-20 00:00:00`.
         */
        public string $startTime,
        /**
         * Дата й час у форматі РРРР-ММ-ДД гг:хх:сс, до якої (не включно) запитуються події.
         * Приклад: `2022-07-21 00:00:00`.
         */
        public ?string $endTime = null,
        /**
         * Максимальна кількість подій, що повертаються, за замовчуванням 50. Якщо це значення перевищує 100 000, буде
         * створено декілька файлів, кожен з яких містить максимум 100 000 подій.
         * Приклад: `50`.
         */
        public ?int $limit = null,
        /**
         * Якщо у користувача увімкнено проєкти, all_projects=true дозволить отримати дані всіх проєктів.
         * За замовчуванням: `False`.
         */
        public ?bool $allProjects = null,
        /**
         * Об'єкт із властивостями фільтра дампа подій.
         */
        public ?FilterObject $filter = null,
        /**
         * Масив із рядків з переліком назв стовпців, які необхідно отримати у вивантаженні (у порядку переліку). Якщо
         * 'dump_fields' відсутній або порожній — застосовується набір і порядок полів за замовчуванням. Припустимі
         * значення (у порядку за замовчуванням): 'project_id', 'event_time', 'job_id', 'from_email', 'email', 'status',
         * 'delivery_status', 'metadata', 'destination_response', 'user_agent', 'url', 'ip', 'tags'. З метою більшої
         * конфіденційності поле 'subject' не входить до набору полів за замовчуванням, але ви можете додати його,
         * вказавши в параметрі 'dump_fields'.
         * @var list<string>|null
         */
        public ?array $dumpFields = null,
        /**
         * Дозволяє отримати агреговану статистику за вказаний період. Може набувати одного з двох значень:
         *
         * - __day_status__ - отримати агреговану статистику; за такого значення параметр filter має бути відсутнім або порожнім об'єктом (фільтри неприпустимі);
         * - __порожній рядок__ - значення за замовчуванням, еквівалентне відсутності параметра aggregate, і метод event_dump/create у цьому разі працює як раніше.
         * Приклад: `day_status`.
         */
        public ?string $aggregate = null,
        /**
         * Роздільник полів, за замовчуванням ','. Припустимі значення ',' і ';'.
         * Приклад: `;`.
         */
        public ?string $delimiter = null,
        /**
         * Формат отримуваного файлу “csv” (за замовчуванням) або “csv_gzip”.
         * За замовчуванням: `csv`.
         * Приклад: `csv`.
         */
        public ?string $format = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            startTime: Data::string($data['start_time'] ?? null) ?? '',
            endTime: Data::string($data['end_time'] ?? null),
            limit: Data::int($data['limit'] ?? null),
            allProjects: Data::bool($data['all_projects'] ?? null),
            filter: Data::model(FilterObject::class, $data['filter'] ?? null),
            dumpFields: Data::list($data['dump_fields'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            aggregate: Data::string($data['aggregate'] ?? null),
            delimiter: Data::string($data['delimiter'] ?? null),
            format: Data::string($data['format'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'limit' => $this->limit,
            'all_projects' => $this->allProjects,
            'filter' => null === $this->filter ? null : Data::object($this->filter->toArray()),
            'dump_fields' => $this->dumpFields,
            'aggregate' => $this->aggregate,
            'delimiter' => $this->delimiter,
            'format' => $this->format,
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
