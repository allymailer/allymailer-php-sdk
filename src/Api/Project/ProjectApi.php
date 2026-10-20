<?php

declare(strict_types=1);

namespace AllyMailer\Api\Project;

use AllyMailer\Api\Project\Model\ProjectCreateRequest;
use AllyMailer\Api\Project\Model\ProjectCreateResponse;
use AllyMailer\Api\Project\Model\ProjectDeleteRequest;
use AllyMailer\Api\Project\Model\ProjectListRequest;
use AllyMailer\Api\Project\Model\ProjectListResponse;
use AllyMailer\Api\Project\Model\ProjectUpdateRequest;
use AllyMailer\Api\Project\Model\ProjectUpdateResponse;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;
use AllyMailer\Common\Model\SuccessResponse;

/**
 * Проєкти дозволяють об'єднати кілька незалежних доменів із webhook, шаблонами та списками відписки. Це дуже
 * корисно, якщо у вас є власні клієнти і ви керуєте їхніми даними з одного облікового запису AllyMailer. Кожен
 * проєкт отримує власний ключ API, а виклики методів API з цим ключем обробляють лише дані цього проєкту. Таким
 * чином, ви можете призначити окремий проєкт для кожного користувача і бути впевненими, що вони не
 * конфліктуватимуть: наприклад, відписка від одного проєкту не вплине на інший.
 *
 * Методи проєктів за замовчуванням вимкнено через заходи захисту від спаму. Щоб їх увімкнути, вам необхідно
 * звернутися до [служби підтримки](https://cp.allymailer.com/ua/support).
 *
 * Зверніть увагу: за замовчуванням домени для надсилання підтверджуються та використовуються незалежно для
 * основного облікового запису й кожного з проєктів. Але є можливість увімкнути для проєктів використання
 * доменів, підтверджених в основному обліковому записі. Просто попросіть про це
 * [техпідтримку](https://cp.allymailer.com/ua/support).
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->project()->create(new ProjectCreateRequest(
 *     (new ProjectObject('Project 1A'))
 *         ->setCountry('ES')
 *         ->setBackendDomainId(1234)
 *         ->setUnsubscribePageId(1)
 * ));
 * echo $response->getProjectId(), PHP_EOL;
 * ```
 */
final class ProjectApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Створити новий проєкт.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#project-create
     *
     * @throws ApiException
     */
    public function create(ProjectCreateRequest $request): ProjectCreateResponse
    {
        return ProjectCreateResponse::fromArray($this->client->call('/project/create.json', $request->toArray()));
    }

    /**
     * Змінити властивості проєкту.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#project-update
     *
     * @throws ApiException
     */
    public function update(ProjectUpdateRequest $request): ProjectUpdateResponse
    {
        return ProjectUpdateResponse::fromArray($this->client->call('/project/update.json', $request->toArray()));
    }

    /**
     * Повертає список проєктів.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#project-list
     *
     * @throws ApiException
     */
    public function list(ProjectListRequest $request): ProjectListResponse
    {
        return ProjectListResponse::fromArray($this->client->call('/project/list.json', $request->toArray()));
    }

    /**
     * Видалити проєкт.
     *
     * Деякий час проєкт не видаляється остаточно, і його ще можна відновити — для цього необхідно звернутися в
     * техпідтримку.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#project-delete
     *
     * @throws ApiException
     */
    public function delete(ProjectDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/project/delete.json', $request->toArray()));
    }
}
