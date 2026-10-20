<?php

declare(strict_types=1);

namespace AllyMailer\Api\System;

use AllyMailer\Api\System\Model\SystemInfoResponse;
use AllyMailer\Api\System\Model\SystemPingResponse;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;

/**
 * Системні методи.
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->system()->ping();
 * echo $response->getUserId(), PHP_EOL;
 * ```
 */
final class SystemApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Перевіряє валідність API-ключа та повертає ідентифікатор користувача.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#system-ping
     *
     * @throws ApiException
     */
    public function ping(): SystemPingResponse
    {
        return SystemPingResponse::fromArray($this->client->call('/system/ping.json'));
    }

    /**
     * Повертає інформацію про користувача або проєкт за API-ключем.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#system-info
     *
     * @throws ApiException
     */
    public function info(): SystemInfoResponse
    {
        return SystemInfoResponse::fromArray($this->client->call('/system/info.json'));
    }
}
