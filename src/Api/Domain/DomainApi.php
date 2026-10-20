<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain;

use AllyMailer\Api\Domain\Model\DomainDeleteRequest;
use AllyMailer\Api\Domain\Model\DomainDeleteResponse;
use AllyMailer\Api\Domain\Model\DomainGetDnsRecordsRequest;
use AllyMailer\Api\Domain\Model\DomainGetDnsRecordsResponse;
use AllyMailer\Api\Domain\Model\DomainGetSandboxDomainResponse;
use AllyMailer\Api\Domain\Model\DomainListRequest;
use AllyMailer\Api\Domain\Model\DomainListResponse;
use AllyMailer\Api\Domain\Model\DomainValidateDkimRequest;
use AllyMailer\Api\Domain\Model\DomainValidateDkimResponse;
use AllyMailer\Api\Domain\Model\DomainValidateVerificationRecordRequest;
use AllyMailer\Api\Domain\Model\DomainValidateVerificationRecordResponse;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\ApiException;

/**
 * Методи для налаштування доменів надсилання та перевірки їх статусів. Корисні, якщо вам недостатньо додавання
 * доменів через вебінтерфейс AllyMailer і, наприклад, хочеться автоматизувати додавання доменів для ваших
 * власних клієнтів.
 *
 * Щоб додати новий домен надсилання через API, ви маєте зробити таке:
 * - Підтвердіть домен, з якого надсилатимуться листи, внісши необхідні DNS-записи, отримавши їх за допомогою методу [domain/get-dns-records](https://docs.allymailer.com.ua/ua/web-api-ref#domain-get-dns-records).
 * - Після додавання раз на 5–10 хвилин викликайте [domain/list](https://docs.allymailer.com.ua/ua/web-api-ref#domain-list) із зазначенням доданого домену (або кількох доменів одразу, якщо перевірити треба декілька) і перевіряйте verification-record.status та dkim.status у відповіді domain/list. Можна робити запит і частіше — але точно не частіше за раз на хвилину.
 * - Якщо verification-record.status="unconfirmed", то ініціюйте перевірку правильності запису володіння доменом за допомогою виклику [domain/validate-verification-record](https://docs.allymailer.com.ua/ua/web-api-ref#domain-validate-verification-record).
 * - Якщо dkim.status="inactive", то ініціюйте перевірку правильності DKIM-запису за допомогою виклику [domain/validate-dkim](https://docs.allymailer.com.ua/ua/web-api-ref#domain-validate-dkim) (втім, DKIM-записи AllyMailer і сам перевіряє раз на пів години).
 * - І лише коли domain/list повернув verification-record.status="confirmed" та dkim.status="active" для домену, можна використовувати домен для надсилання та припинити його очікування й виклики для нього зазначених вище методів.
 *
 * Приклад:
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 *
 * $response = $client->domain()->getDnsRecords(new DomainGetDnsRecordsRequest(
 *     domain: 'example.com',
 * ));
 * echo $response->domain, PHP_EOL;
 * ```
 */
final class DomainApi
{
    public function __construct(
        private readonly ApiClient $client,
    ) {
    }

    /**
     * Повертає інформацію про записи, які потрібно внести в DNS для використання домену в AllyMailer.
     *
     * Щоб надсилати листи, вам потрібно підтвердити володіння доменом, зі зворотною адресою якого ви збираєтеся їх
     * надсилати, а також налаштувати DKIM-підпис для цього домену. Метод дозволяє вам зареєструвати домен у
     * AllyMailer і згенерувати запис для перевірки володіння та DKIM-ключ, або отримати їх, якщо вони були
     * згенеровані раніше.
     *
     * Після отримання успішної відповіді вам потрібно додати DNS-записи на кшталт цих:
     *
     * `@             IN TXT "allymailer-validate-hash=483bb362ebdbeedd755cfb1d4d661"`
     *
     * `us._domainkey IN TXT "k=rsa; p=MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDo7"`
     *
     * `@             IN TXT  "v=spf1 include:spf.allymailer.com.ua ~all"`
     *
     * - Перший запис представлено вмістом поля "verification-record".
     * - Другий запис має включати вміст поля "dkim" одразу після "p=". Зверніть увагу на ім'я запису! Префікс "us._domainkey." дуже важливий для того, щоб DKIM-селектор AllyMailer працював правильно.
     * - Третій запис необов'язковий, але ми дуже рекомендуємо його додавати — це SPF-запис, який підвищує доставлюваність. Можливо, вона у вас уже є — у цьому разі просто додайте include:spf.allymailer.com.ua після v=spf1.
     *
     * Вимоги до синтаксису записів у різних DNS-провайдерів можуть відрізнятися:
     * - іноді потрібно вказувати повне ім'я домену із завершальною крапкою, на кшталт "example.com." замість символа @.
     * - деякі провайдери вимагають указувати час життя (TTL, наприклад 3600)
     * - для деяких провайдерів буде зайвим поміщення значень у подвійні лапки
     * Будь ласка, перевірте вимоги свого провайдера й підкажіть це своїм користувачам.
     *
     * Для реалізації white-label рішень є можливість змінити стандартні DNS-записи на ті, що не містять підрядка
     * "allymailer". Щоб дізнатися докладніше — напишіть у техпідтримку.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#domain-get-dns-records
     *
     * @throws ApiException
     */
    public function getDnsRecords(DomainGetDnsRecordsRequest $request): DomainGetDnsRecordsResponse
    {
        return DomainGetDnsRecordsResponse::fromArray($this->client->call('/domain/get-dns-records.json', $request->toArray()));
    }

    /**
     * Ініціює перевірку запису про володіння доменом.
     *
     * Якщо результат виклику цього методу успішний (200 OK) — це означає, що перевірку запущено. Для отримання
     * результату потрібно пізніше перевірити поле verification-record.status, що повертається методом
     * [domain/list](https://docs.allymailer.com.ua/ua/web-api-ref#domain-list). Докладніше читайте
     * [тут](https://docs.allymailer.com.ua/ua/web-api-ref#domain).
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#domain-validate-verification-record
     *
     * @throws ApiException
     */
    public function validateVerificationRecord(DomainValidateVerificationRecordRequest $request): DomainValidateVerificationRecordResponse
    {
        return DomainValidateVerificationRecordResponse::fromArray($this->client->call('/domain/validate-verification-record.json', $request->toArray()));
    }

    /**
     * Перевіряє DKIM-запис домену.
     *
     * Якщо результат виклику цього методу успішний (200 OK) — це означає, що перевірку запущено. Для отримання
     * результату потрібно пізніше перевірити поле dkim.status, що повертається методом
     * [domain/list](https://docs.allymailer.com.ua/ua/web-api-ref#domain-list). Докладніше читайте
     * [тут](https://docs.allymailer.com.ua/ua/web-api-ref#domain).
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#domain-validate-dkim
     *
     * @throws ApiException
     */
    public function validateDkim(DomainValidateDkimRequest $request): DomainValidateDkimResponse
    {
        return DomainValidateDkimResponse::fromArray($this->client->call('/domain/validate-dkim.json', $request->toArray()));
    }

    /**
     * Повертає список усіх зареєстрованих доменів користувача або проєкту разом зі статусами останніх перевірок.
     *
     * Повертає статус останньої перевірки DNS-запису володіння доменом і DKIM-запису для кожного домену. Докладніше
     * [тут](https://docs.allymailer.com.ua/ua/web-api-ref#domain).
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#domain-list
     *
     * @throws ApiException
     */
    public function list(DomainListRequest $request): DomainListResponse
    {
        return DomainListResponse::fromArray($this->client->call('/domain/list.json', $request->toArray()));
    }

    /**
     * Створює sandbox-домен облікового запису або повертає наявний.
     *
     * Повертає sandbox-домен облікового запису, готовий до використання в полі `from_email` методу
     * [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send). Якщо sandbox-домену немає, AllyMailer
     * створює його та повертає. Повторні виклики повертають той самий домен.
     *
     * Метод доступний лише з API-ключем облікового запису. API-ключі проєктів не можуть створювати sandbox-домени.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#domain-get-sandbox-domain
     *
     * @throws ApiException
     */
    public function getSandboxDomain(): DomainGetSandboxDomainResponse
    {
        return DomainGetSandboxDomainResponse::fromArray($this->client->call('/domain/get-sandbox-domain.json'));
    }

    /**
     * Видаляє домен. Увага: для видалення домену, що належить проєкту, вам потрібно використати API-ключ проєкту.
     *
     * Видаляє домен.
     *
     * @see https://docs.allymailer.com.ua/ua/web-api-ref#domain-delete
     *
     * @throws ApiException
     */
    public function delete(DomainDeleteRequest $request): DomainDeleteResponse
    {
        return DomainDeleteResponse::fromArray($this->client->call('/domain/delete.json', $request->toArray()));
    }
}
