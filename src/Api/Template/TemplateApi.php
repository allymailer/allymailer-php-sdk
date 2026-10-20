<?php

declare(strict_types=1);

namespace AllyMailer\Api\Template;

use AllyMailer\Api\Template\Model\TemplateDeleteRequest;
use AllyMailer\Api\Template\Model\TemplateGetRequest;
use AllyMailer\Api\Template\Model\TemplateGetResponse;
use AllyMailer\Api\Template\Model\TemplateListRequest;
use AllyMailer\Api\Template\Model\TemplateListResponse;
use AllyMailer\Api\Template\Model\TemplateSetRequest;
use AllyMailer\Api\Template\Model\TemplateSetResponse;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;
use AllyMailer\Common\Model\SuccessResponse;

/**
 * Ви можете зберегти шаблон на боці AllyMailer і потім посилатися на нього за ідентифікатором. Це не
 * обов'язково, але вкрай рекомендовано у разі повторюваних email-повідомлень або за великих обсягів надсилання.
 * AllyMailer підтримує два різні синтаксиси для шаблонів, докладніше читайте
 * [тут](https://docs.allymailer.com.ua/en/template-engines).
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->template()->set(new TemplateSetRequest(
 *     template: new TemplateObject(
 *         name: 'name',
 *         editorType: EditorType::Html,
 *         templateEngine: TemplateEngine::Velocity,
 *         subject: 'AllyMailer test email ',
 *         fromEmail: 'user@example.com',
 *         fromName: 'John Smith',
 *         replyTo: 'email@example.com',
 *         replyToName: 'John Smith',
 *     ),
 * ));
 * var_dump($response->template);
 * ```
 */
final class TemplateApi
{
    public function __construct(
        private readonly ApiClient $client,
    ) {
    }

    /**
     * Створити або оновити шаблон.
     *
     * Обмеження:
     * * Максимальний розмір запиту — 10 MB.
     * * Кількість шаблонів обмежено 10000.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#template-set
     *
     * @throws ApiException
     */
    public function set(TemplateSetRequest $request): TemplateSetResponse
    {
        return TemplateSetResponse::fromArray($this->client->call('/template/set.json', $request->toArray()));
    }

    /**
     * Повертає властивості шаблону за його ідентифікатором.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#template-get
     *
     * @throws ApiException
     */
    public function get(TemplateGetRequest $request): TemplateGetResponse
    {
        return TemplateGetResponse::fromArray($this->client->call('/template/get.json', $request->toArray()));
    }

    /**
     * Повертає повний список або частину списку всіх шаблонів.
     *
     * Ви можете переглядати великий список частинами, використовуючи параметри "offset" і "limit". Якщо повернуто
     * менше ніж "limit" шаблонів — значить, ви досягли кінця списку.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#template-list
     *
     * @throws ApiException
     */
    public function list(TemplateListRequest $request): TemplateListResponse
    {
        return TemplateListResponse::fromArray($this->client->call('/template/list.json', $request->toArray()));
    }

    /**
     * Видаляє шаблон за ідентифікатором.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#template-delete
     *
     * @throws ApiException
     */
    public function delete(TemplateDeleteRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/template/delete.json', $request->toArray()));
    }
}
