<?php

declare(strict_types=1);

namespace AllyMailer\Api\Suppression;

use AllyMailer\Api\Suppression\Model\SuppressionDeleteRequest;
use AllyMailer\Api\Suppression\Model\SuppressionGetRequest;
use AllyMailer\Api\Suppression\Model\SuppressionGetResponse;
use AllyMailer\Api\Suppression\Model\SuppressionListRequest;
use AllyMailer\Api\Suppression\Model\SuppressionListResponse;
use AllyMailer\Api\Suppression\Model\SuppressionSetRequest;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;
use AllyMailer\Common\Model\SuccessResponse;

/**
 * Методи для керування адресами, надсилання на які заблоковано з різних причин — відписка, недоступність,
 * скарги.
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->suppression()->set(new SuppressionSetRequest(
 *     email: 'email@example.com',
 *     cause: 'unsubscribed',
 *     created: '2021-12-19 10:15:49',
 * ));
 * ```
 */
final class SuppressionApi
{
    public function __construct(
        private readonly ApiClient $client,
    ) {
    }

    /**
     * Додає email-адресу до списку недоступних. Ви завжди зможете пізніше видалити цю адресу зі списку недоступних
     * методом [suppression/delete](https://docs.allymailer.com.ua/ua/web-api-ref#suppression-delete).
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#suppression-set
     *
     * @throws ApiException
     */
    public function set(SuppressionSetRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/suppression/set.json', $request->toArray()));
    }

    /**
     * Повертає причину й дату блокування email-адреси.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#suppression-get
     *
     * @throws ApiException
     */
    public function get(SuppressionGetRequest $request): SuppressionGetResponse
    {
        return SuppressionGetResponse::fromArray($this->client->call('/suppression/get.json', $request->toArray()));
    }

    /**
     * Повертає список недоступних, починаючи з указаної дати.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#suppression-list
     *
     * @throws ApiException
     */
    public function list(SuppressionListRequest $request): SuppressionListResponse
    {
        return SuppressionListResponse::fromArray($this->client->call('/suppression/list.json', $request->toArray()));
    }

    /**
     * Видаляє email-адресу зі списку недоступних (лише записи з is_deletable=true). Якщо жодного запису для email не
     * знайдено, повертається помилка API 3003. Якщо записи про недоступність знайдено, але жодну з них видалити не
     * можна, повертається помилка API 3004. Якщо перевищено ліміт видалень на добу, повертається помилка API 906.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#suppression-delete
     *
     * @throws ApiException
     */
    public function delete(SuppressionDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/suppression/delete.json', $request->toArray()));
    }
}
