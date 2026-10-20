<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete;

use AllyMailer\Api\Obsolete\Model\ObsoleteUnsubscribedCheckRequest;
use AllyMailer\Api\Obsolete\Model\ObsoleteUnsubscribedCheckResponse;
use AllyMailer\Api\Obsolete\Model\ObsoleteUnsubscribedListRequest;
use AllyMailer\Api\Obsolete\Model\ObsoleteUnsubscribedListResponse;
use AllyMailer\Api\Obsolete\Model\ObsoleteUnsubscribedSetRequest;
use AllyMailer\Api\Obsolete\Model\ObsoleteUnsubscribedSetResponse;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;

/**
 * Застарілі методи роботи з відписками. Ми рекомендуємо користуватися замість них гнучкішими методами
 * [suppression](https://docs.allymailer.com.ua/ua/web-api-ref#suppression). Зверніть увагу, що знову підписати
 * відписаного адресата через WebAPI не можна. Можна лише надіслати йому email із посиланням повторної підписки
 * за допомогою методу email/subscribe.
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->obsolete()->unsubscribedSet(new ObsoleteUnsubscribedSetRequest('email@example.com'));
 * echo $response->getAddress(), PHP_EOL;
 * ```
 */
final class ObsoleteApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Внести email до списку відписаних.
     *
     * Після внесення email до списку відписаних усі майбутні спроби надіслати на нього повідомлення будуть
     * відхилятися. Зауважте, що видалити email зі списку відписаних безпосередньо за допомогою API не можна. Але
     * можна надіслати йому повідомлення з посиланням повторної підписки за допомогою методу
     * [email/subscribe](https://docs.allymailer.com.ua/ua/web-api-ref#email-subscribe) або видалити його зі списку
     * відписаних вручну на сторінці [Пошук email](https://cp.allymailer.com/ua/user/email) у панелі керування (але
     * кількість таких видалень на день сильно обмежена).
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#unsubscribed-set
     *
     * @throws ApiException
     */
    public function unsubscribedSet(ObsoleteUnsubscribedSetRequest $request): ObsoleteUnsubscribedSetResponse
    {
        return ObsoleteUnsubscribedSetResponse::fromArray($this->client->call('/unsubscribed/set.json', $request->toArray()));
    }

    /**
     * Перевіряє, чи відписано email.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#unsubscribed-check
     *
     * @throws ApiException
     */
    public function unsubscribedCheck(ObsoleteUnsubscribedCheckRequest $request): ObsoleteUnsubscribedCheckResponse
    {
        return ObsoleteUnsubscribedCheckResponse::fromArray($this->client->call('/unsubscribed/check.json', $request->toArray()));
    }

    /**
     * Повертає список адрес, відписаних починаючи з указаної дати.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#unsubscribed-list
     *
     * @throws ApiException
     */
    public function unsubscribedList(ObsoleteUnsubscribedListRequest $request): ObsoleteUnsubscribedListResponse
    {
        return ObsoleteUnsubscribedListResponse::fromArray($this->client->call('/unsubscribed/list.json', $request->toArray()));
    }
}
