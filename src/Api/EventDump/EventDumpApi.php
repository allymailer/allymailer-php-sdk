<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump;

use AllyMailer\Api\EventDump\Model\EventDumpCreateRequest;
use AllyMailer\Api\EventDump\Model\EventDumpCreateResponse;
use AllyMailer\Api\EventDump\Model\EventDumpDeleteRequest;
use AllyMailer\Api\EventDump\Model\EventDumpGetRequest;
use AllyMailer\Api\EventDump\Model\EventDumpGetResponse;
use AllyMailer\Api\EventDump\Model\EventDumpListResponse;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;
use AllyMailer\Common\Model\SuccessResponse;

/**
 * Методи для отримання списку подій, що сталися, за певний період. Дані зберігаються до 45 днів, залежно від
 * вашого тарифу. Це означає, що можна запросити події, починаючи з 00:00:00 45-го дня тому і до поточного
 * моменту часу. Для індивідуальних тарифів з великими обсягами за замовчуванням події доступні лише за останні 7
 * днів.
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->eventDump()->create(new EventDumpCreateRequest(
 *     startTime: '2022-07-20 00:00:00',
 *     endTime: '2022-07-21 00:00:00',
 *     limit: 50,
 *     dumpFields: ['string1'],
 *     aggregate: 'day_status',
 *     delimiter: ';',
 *     format: 'csv',
 * ));
 * echo $response->dumpId, PHP_EOL;
 * ```
 */
final class EventDumpApi
{
    public function __construct(
        private readonly ApiClient $client,
    ) {
    }

    /**
     * Асинхронний метод, який ініціює підготовку для завантаження файлів дампа у форматі CSV. Максимальна кількість
     * збережених/створюваних дампів обмежена десятьма. У разі досягнення ліміту для запиту на підготовку нового
     * дампа потрібно видалити старі. Час зберігання сформованого дампа — 8 годин, після чого він автоматично
     * видаляється. Якщо період запиту даних більший за добу або подій багато, буде сформовано декілька файлів, у
     * кожному з яких буде не більше ніж 100 000 подій. Файл містить колонки з такою інформацією — 'event_time',
     * 'job_id', 'from_email', 'email', 'status', 'delivery_status', 'metadata', 'destination_response',
     * 'user_agent', 'url', 'ip', 'tags' і 'project_id' (якщо у користувача увімкнено проєкти). Ви можете
     * відфільтрувати поля та змінити їх порядок, а також додати поле 'subject' за допомогою параметра 'dump_fileds'.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-create
     *
     * @throws ApiException
     */
    public function create(EventDumpCreateRequest $request): EventDumpCreateResponse
    {
        return EventDumpCreateResponse::fromArray($this->client->call('/event-dump/create.json', $request->toArray()));
    }

    /**
     * Повертає властивості дампа за його ідентифікатором.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-get
     *
     * @throws ApiException
     */
    public function get(EventDumpGetRequest $request): EventDumpGetResponse
    {
        return EventDumpGetResponse::fromArray($this->client->call('/event-dump/get.json', $request->toArray()));
    }

    /**
     * Метод без параметрів, повертає список усіх дампів подій.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-list
     *
     * @throws ApiException
     */
    public function list(): EventDumpListResponse
    {
        return EventDumpListResponse::fromArray($this->client->call('/event-dump/list.json'));
    }

    /**
     * Видаляє дамп із черги та/або зі сховища.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#event-dump-delete
     *
     * @throws ApiException
     */
    public function delete(EventDumpDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/event-dump/delete.json', $request->toArray()));
    }
}
