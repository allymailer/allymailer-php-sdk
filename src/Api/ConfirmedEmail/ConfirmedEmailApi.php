<?php

declare(strict_types=1);

namespace AllyMailer\Api\ConfirmedEmail;

use AllyMailer\Api\ConfirmedEmail\Model\ConfirmedEmailCreateResponse;
use AllyMailer\Api\ConfirmedEmail\Model\ConfirmedEmailDeleteResponse;
use AllyMailer\Api\ConfirmedEmail\Model\ConfirmedEmailListResponse;
use AllyMailer\Api\ConfirmedEmail\Model\ConfirmedEmailRequest;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;

/**
 * Керування email-адресами, підтвердженими для надсилання із sandbox-домену. Методи доступні лише з API-ключем
 * основного облікового запису.
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->confirmedEmail()->create(new ConfirmedEmailRequest(
 *     email: 'dev@example.com',
 * ));
 * var_dump($response->confirmedEmail);
 * ```
 */
final class ConfirmedEmailApi
{
    public function __construct(
        private readonly ApiClient $client,
    ) {
    }

    /**
     * Adds an email address and sends a confirmation link.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#confirmed-email-create
     *
     * @throws ApiException
     */
    public function create(ConfirmedEmailRequest $request): ConfirmedEmailCreateResponse
    {
        return ConfirmedEmailCreateResponse::fromArray($this->client->call('/confirmed-email/create.json', $request->toArray()));
    }

    /**
     * Lists confirmed and unconfirmed email addresses for the account.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#confirmed-email-list
     *
     * @throws ApiException
     */
    public function list(): ConfirmedEmailListResponse
    {
        return ConfirmedEmailListResponse::fromArray($this->client->call('/confirmed-email/list.json'));
    }

    /**
     * Deletes an email address from the account's confirmed email list.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#confirmed-email-delete
     *
     * @throws ApiException
     */
    public function delete(ConfirmedEmailRequest $request): ConfirmedEmailDeleteResponse
    {
        return ConfirmedEmailDeleteResponse::fromArray($this->client->call('/confirmed-email/delete.json', $request->toArray()));
    }
}
