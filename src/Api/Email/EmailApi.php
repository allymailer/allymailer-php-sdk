<?php

declare(strict_types=1);

namespace AllyMailer\Api\Email;

use AllyMailer\Api\Email\Model\EmailSendRequest;
use AllyMailer\Api\Email\Model\EmailSendResponse;
use AllyMailer\Api\Email\Model\EmailSubscribeRequest;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;
use AllyMailer\Common\Model\SuccessResponse;

/**
 * Ця група методів пов'язана з надсиланням email.
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->email()->send(new EmailSendRequest(
 *     (new MessageObject(
 *         [
 *             (new MessageObjectRecipientsItem('user@example.com'))
 *                 ->setSubstitutions([
 *                     'CustomerId' => '12452',
 *                     'to_name' => 'John Smith',
 *                 ])
 *                 ->setMetadata([
 *                     'campaign_id' => 'c77f4f4e-3561-49f7-9f07-c35be01b4f43',
 *                     'customer_hash' => 'b253ac7',
 *                 ]),
 *         ],
 *         (new BodyObject())
 *             ->setHtml('<b>Hello, {{to_name}}</b>')
 *             ->setPlaintext('Hello, {{to_name}}')
 *             ->setAmp('<!doctype html><html amp4email><head> <meta charset="utf-8"><script async src="https://cdn.ampproject.org/v0.js"></script> <style amp4email-boilerplate>body{visibility:hidden}</style></head><body> Hello, AMP4EMAIL world.</body></html>'),
 *         'AllyMailer test email '
 *     ))
 *         ->setTemplateId('00000000-0000-0000-0000-000000000000')
 *         ->setGlobalLanguage('en')
 *         ->setTemplateEngine(TemplateEngine::VELOCITY)
 *         ->setFromEmail('email@example.com')
 *         ->setFromName('John Smith')
 *         ->setReplyTo('email@example.com')
 *         ->setReplyToName('John Smith')
 *         ->setIdempotenceKey('SG1VsbG68sIH2dvc5mx890kIQ')
 * ));
 * echo $response->getJobId(), PHP_EOL;
 * ```
 */
final class EmailApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Метод для надсилання листів вашим підписникам.
     *
     * Під час надсилання ви можете використовувати підстановки змінних, шаблони, увімкнути відстеження прочитань або
     * переходів за посиланнями та багато іншого.
     *
     * Обмеження:
     * * максимальний розмір запиту — 10 MB
     * * максимальна кількість отримувачів (recipients) — 500 email
     * * у назві вкладень заборонено символ '/'
     *
     * Якщо під час надсилання листа у списку отримувачів будуть некоректно введені, неіснуючі, повторювані або
     * відписані адреси, вони будуть повернуті у відповіді за допомогою параметра failed_emails, лист же буде
     * надіслано на всі інші прийнятні адреси. Якщо всі адреси потраплять до failed_emails, надсилання здійснено не
     * буде, буде повернуто помилку з API-кодом 204.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#email-send
     *
     * @throws ApiException
     */
    public function send(EmailSendRequest $request): EmailSendResponse
    {
        return EmailSendResponse::fromArray($this->client->call('/email/send.json', $request->toArray()));
    }

    /**
     * Надіслати посилання на (пере)підписку.
     *
     * Метод дозволяє повторно підписати колишнього підписника, який відписався раніше, був заблокований через скарги
     * або чия адреса недоступна з якоїсь іншої причини.
     *
     * Під час виклику надсилається лист у нейтральному дизайні з посиланням підписки. При переході за посиланням з
     * email підписник перестає бути недоступним для користувача та/або перестає бути глобально відписаним.
     *
     * За замовчуванням дозволено лише одне надсилання листа повторної підписки на добу. Якщо вам потрібно більше —
     * напишіть у техпідтримку.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#email-subscribe
     *
     * @throws ApiException
     */
    public function subscribe(EmailSubscribeRequest $request): SuccessResponse
    {
        return SuccessResponse::fromArray($this->client->call('/email/subscribe.json', $request->toArray()));
    }
}
