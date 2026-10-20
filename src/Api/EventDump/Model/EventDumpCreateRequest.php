<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;

/**
 * EventDumpCreateRequest
 */
final class EventDumpCreateRequest implements \JsonSerializable
{
    /**
     * Дата й час у форматі РРРР-ММ-ДД гг:хх:сс, починаючи з якої необхідно отримати події. Дані зберігаються до 45
     * днів, залежно від вашого тарифу.
     * Приклад: `2022-07-20 00:00:00`.
     *
     * @var string
     */
    private $startTime;

    /**
     * Дата й час у форматі РРРР-ММ-ДД гг:хх:сс, до якої (не включно) запитуються події.
     * Приклад: `2022-07-21 00:00:00`.
     *
     * @var string|null
     */
    private $endTime;

    /**
     * Максимальна кількість подій, що повертаються, за замовчуванням 50. Якщо це значення перевищує 100 000, буде
     * створено декілька файлів, кожен з яких містить максимум 100 000 подій.
     * Приклад: `50`.
     *
     * @var int|null
     */
    private $limit;

    /**
     * Якщо у користувача увімкнено проєкти, all_projects=true дозволить отримати дані всіх проєктів.
     * За замовчуванням: `False`.
     *
     * @var bool|null
     */
    private $allProjects;

    /**
     * Об'єкт із властивостями фільтра дампа подій.
     *
     * @var FilterObject|null
     */
    private $filter;

    /**
     * Масив із рядків з переліком назв стовпців, які необхідно отримати у вивантаженні (у порядку переліку). Якщо
     * 'dump_fields' відсутній або порожній — застосовується набір і порядок полів за замовчуванням. Припустимі
     * значення (у порядку за замовчуванням): 'project_id', 'event_time', 'job_id', 'from_email', 'email', 'status',
     * 'delivery_status', 'metadata', 'destination_response', 'user_agent', 'url', 'ip', 'tags'. З метою більшої
     * конфіденційності поле 'subject' не входить до набору полів за замовчуванням, але ви можете додати його,
     * вказавши в параметрі 'dump_fields'.
     *
     * @var list<string>|null
     */
    private $dumpFields;

    /**
     * Дозволяє отримати агреговану статистику за вказаний період. Може набувати одного з двох значень:
     *
     * - __day_status__ - отримати агреговану статистику; за такого значення параметр filter має бути відсутнім або порожнім об'єктом (фільтри неприпустимі);
     * - __порожній рядок__ - значення за замовчуванням, еквівалентне відсутності параметра aggregate, і метод event_dump/create у цьому разі працює як раніше.
     * Приклад: `day_status`.
     *
     * @var string|null
     */
    private $aggregate;

    /**
     * Роздільник полів, за замовчуванням ','. Припустимі значення ',' і ';'.
     * Приклад: `;`.
     *
     * @var string|null
     */
    private $delimiter;

    /**
     * Формат отримуваного файлу “csv” (за замовчуванням) або “csv_gzip”.
     * За замовчуванням: `csv`.
     * Приклад: `csv`.
     *
     * @var string|null
     */
    private $format;

    public function __construct(string $startTime)
    {
        $this->startTime = $startTime;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(Data::string($data['start_time'] ?? null) ?? '');
        $model->endTime = Data::string($data['end_time'] ?? null);
        $model->limit = Data::int($data['limit'] ?? null);
        $model->allProjects = Data::bool($data['all_projects'] ?? null);
        $model->filter = Data::model(FilterObject::class, $data['filter'] ?? null);
        $model->dumpFields = Data::list($data['dump_fields'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->aggregate = Data::string($data['aggregate'] ?? null);
        $model->delimiter = Data::string($data['delimiter'] ?? null);
        $model->format = Data::string($data['format'] ?? null);

        return $model;
    }

    /**
     * Дата й час у форматі РРРР-ММ-ДД гг:хх:сс, починаючи з якої необхідно отримати події.
     */
    public function getStartTime(): string
    {
        return $this->startTime;
    }

    /**
     * Дата й час у форматі РРРР-ММ-ДД гг:хх:сс, починаючи з якої необхідно отримати події.
     *
     * @return $this
     */
    public function setStartTime(string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Дата й час у форматі РРРР-ММ-ДД гг:хх:сс, до якої (не включно) запитуються події.
     */
    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    /**
     * Дата й час у форматі РРРР-ММ-ДД гг:хх:сс, до якої (не включно) запитуються події.
     *
     * @return $this
     */
    public function setEndTime(?string $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Максимальна кількість подій, що повертаються, за замовчуванням 50.
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Максимальна кількість подій, що повертаються, за замовчуванням 50.
     *
     * @return $this
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Якщо у користувача увімкнено проєкти, all_projects=true дозволить отримати дані всіх проєктів.
     */
    public function getAllProjects(): ?bool
    {
        return $this->allProjects;
    }

    /**
     * Якщо у користувача увімкнено проєкти, all_projects=true дозволить отримати дані всіх проєктів.
     *
     * @return $this
     */
    public function setAllProjects(?bool $allProjects): self
    {
        $this->allProjects = $allProjects;

        return $this;
    }

    /**
     * Об'єкт із властивостями фільтра дампа подій.
     */
    public function getFilter(): ?FilterObject
    {
        return $this->filter;
    }

    /**
     * Об'єкт із властивостями фільтра дампа подій.
     *
     * @return $this
     */
    public function setFilter(?FilterObject $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Масив із рядків з переліком назв стовпців, які необхідно отримати у вивантаженні (у порядку переліку).
     *
     * @return list<string>|null
     */
    public function getDumpFields(): ?array
    {
        return $this->dumpFields;
    }

    /**
     * Масив із рядків з переліком назв стовпців, які необхідно отримати у вивантаженні (у порядку переліку).
     *
     * @param list<string>|null $dumpFields
     *
     * @return $this
     */
    public function setDumpFields(?array $dumpFields): self
    {
        $this->dumpFields = $dumpFields;

        return $this;
    }

    /**
     * Дозволяє отримати агреговану статистику за вказаний період.
     */
    public function getAggregate(): ?string
    {
        return $this->aggregate;
    }

    /**
     * Дозволяє отримати агреговану статистику за вказаний період.
     *
     * @return $this
     */
    public function setAggregate(?string $aggregate): self
    {
        $this->aggregate = $aggregate;

        return $this;
    }

    /**
     * Роздільник полів, за замовчуванням ','.
     */
    public function getDelimiter(): ?string
    {
        return $this->delimiter;
    }

    /**
     * Роздільник полів, за замовчуванням ','.
     *
     * @return $this
     */
    public function setDelimiter(?string $delimiter): self
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * Формат отримуваного файлу “csv” (за замовчуванням) або “csv_gzip”.
     */
    public function getFormat(): ?string
    {
        return $this->format;
    }

    /**
     * Формат отримуваного файлу “csv” (за замовчуванням) або “csv_gzip”.
     *
     * @return $this
     */
    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
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
