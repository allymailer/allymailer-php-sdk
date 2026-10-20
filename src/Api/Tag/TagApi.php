<?php

declare(strict_types=1);

namespace AllyMailer\Api\Tag;

use AllyMailer\Api\Tag\Model\TagDeleteRequest;
use AllyMailer\Api\Tag\Model\TagListResponse;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;
use AllyMailer\Common\Model\SuccessResponse;

/**
 * Методи керування користувацькими мітками. За допомогою міток ви можете класифікувати листи за потрібними
 * критеріями. Відокремити маркетингові листи від транзакційних або листи з підтвердженням реєстрації від
 * сповіщень про замовлення. AllyMailer дозволяє позначати мітками кожне вихідне повідомлення, а потім
 * сегментувати й аналізувати статистику на основі зазначених під час надсилання міток.
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->tag()->list();
 * var_dump($response->getTags());
 * ```
 */
final class TagApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Метод без параметрів, повертає список усіх користувацьких міток.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#tag-list
     *
     * @throws ApiException
     */
    public function list(): TagListResponse
    {
        return TagListResponse::fromArray($this->client->call('/tag/list.json'));
    }

    /**
     * Видаляє мітку.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#tag-delete
     *
     * @throws ApiException
     */
    public function delete(TagDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/tag/delete.json', $request->toArray()));
    }
}
