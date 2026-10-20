<?php

declare(strict_types=1);

namespace AllyMailer\Api\EmailValidation;

use AllyMailer\Api\EmailValidation\Model\EmailValidationSingleRequest;
use AllyMailer\Api\EmailValidation\Model\EmailValidationSingleResponse;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;

/**
 * Методи перевірки email-адрес. Перевірка адреси електронної пошти надає докладну інформацію про працездатність
 * email. Це дозволить виключити з надсилання неіснуючі email, знизити показник скарг, очистити список
 * підписників і врешті-решт покращити вашу репутацію як відправника. Наприклад, ви можете інтегрувати процес
 * перевірки у форму реєстрації вашого сайту і вже на етапі введення адреси повідомляти користувачам, що адреса,
 * яку вони ввели у форму, недійсна.
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->emailValidation()->single(new EmailValidationSingleRequest('email@example.com'));
 * echo $response->getEmail(), PHP_EOL;
 * ```
 */
final class EmailValidationApi
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Допускається не більше ніж два одночасні запити; у разі перевищення буде повернуто помилку. Оскільки перевірка
     * має бути швидкою, ми обмежуємо час, що витрачається на перевірку адреси електронної пошти. Тому, якщо ми
     * зіткнемося з повільним поштовим сервером, час відповіді якого перевищує 5 секунд, результат перевірки може
     * бути невідомим.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#email-validation-single
     *
     * @throws ApiException
     */
    public function single(EmailValidationSingleRequest $request): EmailValidationSingleResponse
    {
        return EmailValidationSingleResponse::fromArray($this->client->call('/email-validation/single.json', $request->toArray()));
    }
}
