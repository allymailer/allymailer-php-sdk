<?php

declare(strict_types=1);

namespace AllyMailer\Api\Email\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\AttachmentsArrayItem;
use AllyMailer\Common\Model\BodyObject;
use AllyMailer\Common\Model\HeadersObject;
use AllyMailer\Common\Model\InlineAttachmentsArrayItem;
use AllyMailer\Common\Model\TemplateEngine;

/**
 * Об'єкт, що містить усі властивості повідомлення, яке надсилається.
 */
final class MessageObject implements \JsonSerializable
{
    /**
     * Масив об'єктів з email-адресами, підстановками та метаданими отримувачів.
     *
     * @var list<MessageObjectRecipientsItem>
     */
    private $recipients;

    /**
     * Унікальний ідентифікатор шаблону, створеного раніше методом
     * [template/set](https://docs.allymailer.com.ua/ua/web-api-ref#template-set). Якщо вказано, то поля шаблону
     * підставляються замість пропущених полів email/send. Наприклад, якщо в email/send не вказано body — береться
     * тіло листа із шаблону, а якщо не вказано subject — береться тема із шаблону.
     * Приклад: `00000000-0000-0000-0000-000000000000`.
     *
     * @var string|null
     */
    private $templateId;

    /**
     * Масив із рядків, до 100 символів у кожному. Максимум 4 рядки в масиві, рядки мають бути унікальними. Для
     * кожного облікового запису/проєкту дозволено не більше ніж 10 000 міток, у разі перевищення метод email/send
     * повертатиме помилку. Мітки можуть використовуватися для категоризації листів за обраними вами критеріями.
     * Мітки передаються методами event-dump.
     *
     * @var list<string>|null
     */
    private $tags;

    /**
     * Пропустити чи не пропускати додавання стандартного блока з посиланням відписки до HTML-частини листа.
     * 1=пропустити, 0=додати, за замовчуванням 0. Для использования skip_unsubscribe=1 вам надо [попросить
     * техподдержку](https://cp.allymailer.com/ru/support) включить такую возможность.
     * Допустимі значення: `0`, `1`.
     * Приклад: `0`.
     *
     * @var int|null
     */
    private $skipUnsubscribe;

    /**
     * Заголовок для вибору мови посилання та сторінки відписки. Припустимі значення "be", "de", "en", "es", "fr",
     * "it", "pl", "pt", "ru", "ua", "kz".
     * Приклад: `en`.
     *
     * @var string|null
     */
    private $globalLanguage;

    /**
     * Параметр для вибору [шаблонізатора](https://docs.allymailer.com.ua/ua/template-engines) — або "simple", або
     * "velocity", або "liquid", або "none". За замовчуванням — "simple".
     * Значення: константи `TemplateEngine`.
     *
     * @var string|null
     */
    private $templateEngine;

    /**
     * Об'єкт для передачі глобальних підстановок (наприклад, назва компанії). Якщо назви змінних повторюються в
     * об'єкті користувацьких підстановок "substitutions", значення змінних будуть взяті з об'єкта "substitutions".
     * Підстановки працюють у параметрах:
     *
     * - body.html
     * - body.plaintext
     * - body.amp
     * - subject
     * - from_name
     * - options.unsubscribe_url
     * Назви змінних можуть містити літери латинського алфавіту, цифри, символ "_". Першим символом може бути лише
     * літера, використання пробілів не допускається.
     *
     * @var array<string, string>|null
     */
    private $globalSubstitutions;

    /**
     * Об'єкт для передачі метаданих, спільних для всіх отримувачів, у форматі: "key": "value". Максимальна кількість
     * ключів: 10; максимальна довжина ключа: 64 символи; максимальна довжина значення ключа: 1024 символи. Метадані
     * передаються під час виклику [webhook](https://docs.allymailer.com.ua/ua/web-api-ref#webhook). Для групування
     * листів в одну розсилку може використовуватися системний ключ "campaign_id" зі значенням у вигляді невід'ємного
     * десяткового цілого до 128 біт або UUID вигляду "c7703772-453e-4c77-a9ae-9a1b94051b5a". Неправильні значення
     * будуть прирівняні до '0'
     *
     * @var array<string, string>|null
     */
    private $globalMetadata;

    /**
     * Об'єкт, що містить у собі html-, plaintext- і amp-частини листа. Або html-, або plaintext-частина має бути
     * присутня обов'язково.
     *
     * @var BodyObject
     */
    private $body;

    /**
     * Тема листа.
     * Приклад: `AllyMailer test email `.
     *
     * @var string
     */
    private $subject;

    /**
     * Email-адреса відправника. Обов'язковий лише за порожнього template_id.
     * Приклад: `email@example.com`.
     *
     * @var string|null
     */
    private $fromEmail;

    /**
     * Ім'я відправника.
     * Приклад: `John Smith`.
     *
     * @var string|null
     */
    private $fromName;

    /**
     * Необов'язкова email-адреса для відповідей (на випадок, якщо відрізняється від адреси відправника)
     * Приклад: `email@example.com`.
     *
     * @var string|null
     */
    private $replyTo;

    /**
     * Необов'язкове ім'я для відповідей (якщо вказано email reply_to і ви хочете, щоб відображався не лише цей
     * email, але й ім'я)
     * Приклад: `John Smith`.
     *
     * @var string|null
     */
    private $replyToName;

    /**
     * 1 = відстеження переходів за посиланнями увімкнено (значення за замовчуванням), 0=вимкнено. Для використання
     * track_links = 0 вам потрібно [попросити техпідтримку](https://cp.allymailer.com/ua/support) увімкнути таку
     * можливість.
     * Допустимі значення: `0`, `1`.
     * Приклад: `0`.
     *
     * @var int|null
     */
    private $trackLinks;

    /**
     * 1 = відстеження прочитань листа увімкнено (значення за замовчуванням), 0 = вимкнено. Для використання
     * track_read = 0 вам потрібно [попросити техпідтримку](https://cp.allymailer.com/ua/support) увімкнути таку
     * можливість.
     * Допустимі значення: `0`, `1`.
     * Приклад: `0`.
     *
     * @var int|null
     */
    private $trackRead;

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список глобальної недоступності, під час надсилання не
     * враховуватимуться дані про недоступність адрес або скарги, отримані під час надсилання іншими користувачами
     * AllyMailer. Для деяких системних записів може бути заборонено
     * Допустимі значення: `0`, `1`.
     * Приклад: `0`.
     *
     * @var int|null
     */
    private $bypassGlobal;

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список недоступних адрес поточного облікового
     * запису/проєкту. Указання 1 можливе лише за одночасного вказання bypass_global=1.
     * Допустимі значення: `0`, `1`.
     * Приклад: `0`.
     *
     * @var int|null
     */
    private $bypassUnavailable;

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список відписаних від розсилок поточного облікового
     * запису/проєкту. Указання 1 можливе лише за одночасного вказання bypass_global=1. Параметр доступний лише тим
     * користувачам, яким [техпідтримка](https://cp.allymailer.com/ua/support) схвалила вимкнення посилання відписки.
     * Допустимі значення: `0`, `1`.
     * Приклад: `0`.
     *
     * @var int|null
     */
    private $bypassUnsubscribed;

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список тих, хто поскаржився на обліковий запис/проєкт.
     * Указання 1 можливе лише за одночасного вказання bypass_global=1. Параметр доступний лише тим користувачам,
     * яким [техпідтримка](https://cp.allymailer.com/ua/support) схвалила вимкнення посилання відписки.
     * Допустимі значення: `0`, `1`.
     * Приклад: `0`.
     *
     * @var int|null
     */
    private $bypassComplained;

    /**
     * Рядок до 64 символів завдовжки з унікальним ключем запиту. Може використовуватися для запобігання випадковому
     * дублюванню листів. У разі повторного надсилання запиту з тим самим ключем протягом хвилини запит буде
     * відхилено. Може створюватися автоматично для кожного листа; щоб увімкнути автоматичну генерацію ключа,
     * зв'яжіться з [техпідтримкою](https://cp.allymailer.com/ua/support).
     * Приклад: `SG1VsbG68sIH2dvc5mx890kIQ`.
     *
     * @var string|null
     */
    private $idempotenceKey;

    /**
     * Об'єкт, що містить додаткові заголовки листа, максимум 50 заголовків. Префікс “X-” в імені заголовка
     * обов'язковий, заголовки без нього будуть проігноровані, наприклад X-ALLYMAILER-Global-Language,
     * X-ALLYMAILER-Template-Engine. Стандартні заголовки "To", "CC", "BCC" передаються без префікса "X-", але
     * обробляються спеціальним чином, тому мають низку обмежень, докладніше про це можна прочитати
     * [тут](/cc-and-bcc). Також якщо [техпідтримка](https://cp.allymailer.com/ua/support) схвалила вам вимкнення
     * посилання відписки, то ви також можете передавати заголовки List-Unsubscribe, List-Subscribe, List-Help,
     * List-Owner, List-Archive, In-Reply-To і References.
     *
     * @var HeadersObject|null
     */
    private $headers;

    /**
     * Необов'язковий масив вкладень.
     *
     * @var list<AttachmentsArrayItem>|null
     */
    private $attachments;

    /**
     * Масив для передачі inline-вкладень, наприклад, для включення зображень у лист замість завантаження їх за
     * посиланням.
     *
     * @var list<InlineAttachmentsArrayItem>|null
     */
    private $inlineAttachments;

    /**
     * Додаткові опції.
     *
     * @var MessageObjectOptions|null
     */
    private $options;

    /**
     * @param list<MessageObjectRecipientsItem> $recipients
     */
    public function __construct(array $recipients, BodyObject $body, string $subject)
    {
        $this->recipients = $recipients;
        $this->body = $body;
        $this->subject = $subject;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self(
            Data::list($data['recipients'] ?? null, static function ($item) { return MessageObjectRecipientsItem::fromArray(Data::array($item) ?? []); }) ?? [],
            BodyObject::fromArray(Data::array($data['body'] ?? null) ?? []),
            Data::string($data['subject'] ?? null) ?? ''
        );
        $model->templateId = Data::string($data['template_id'] ?? null);
        $model->tags = Data::list($data['tags'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->skipUnsubscribe = Data::int($data['skip_unsubscribe'] ?? null);
        $model->globalLanguage = Data::string($data['global_language'] ?? null);
        $model->templateEngine = Data::string($data['template_engine'] ?? null);
        $model->globalSubstitutions = Data::map($data['global_substitutions'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->globalMetadata = Data::map($data['global_metadata'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->fromEmail = Data::string($data['from_email'] ?? null);
        $model->fromName = Data::string($data['from_name'] ?? null);
        $model->replyTo = Data::string($data['reply_to'] ?? null);
        $model->replyToName = Data::string($data['reply_to_name'] ?? null);
        $model->trackLinks = Data::int($data['track_links'] ?? null);
        $model->trackRead = Data::int($data['track_read'] ?? null);
        $model->bypassGlobal = Data::int($data['bypass_global'] ?? null);
        $model->bypassUnavailable = Data::int($data['bypass_unavailable'] ?? null);
        $model->bypassUnsubscribed = Data::int($data['bypass_unsubscribed'] ?? null);
        $model->bypassComplained = Data::int($data['bypass_complained'] ?? null);
        $model->idempotenceKey = Data::string($data['idempotence_key'] ?? null);
        $model->headers = Data::model(HeadersObject::class, $data['headers'] ?? null);
        $model->attachments = Data::list($data['attachments'] ?? null, static function ($item) { return AttachmentsArrayItem::fromArray(Data::array($item) ?? []); });
        $model->inlineAttachments = Data::list($data['inline_attachments'] ?? null, static function ($item) { return InlineAttachmentsArrayItem::fromArray(Data::array($item) ?? []); });
        $model->options = Data::model(MessageObjectOptions::class, $data['options'] ?? null);

        return $model;
    }

    /**
     * Масив об'єктів з email-адресами, підстановками та метаданими отримувачів.
     *
     * @return list<MessageObjectRecipientsItem>
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * Масив об'єктів з email-адресами, підстановками та метаданими отримувачів.
     *
     * @param list<MessageObjectRecipientsItem> $recipients
     *
     * @return $this
     */
    public function setRecipients(array $recipients): self
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * Унікальний ідентифікатор шаблону, створеного раніше методом
     * [template/set](https://docs.allymailer.com.ua/ua/web-api-ref#template-set).
     */
    public function getTemplateId(): ?string
    {
        return $this->templateId;
    }

    /**
     * Унікальний ідентифікатор шаблону, створеного раніше методом
     * [template/set](https://docs.allymailer.com.ua/ua/web-api-ref#template-set).
     *
     * @return $this
     */
    public function setTemplateId(?string $templateId): self
    {
        $this->templateId = $templateId;

        return $this;
    }

    /**
     * Масив із рядків, до 100 символів у кожному.
     *
     * @return list<string>|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * Масив із рядків, до 100 символів у кожному.
     *
     * @param list<string>|null $tags
     *
     * @return $this
     */
    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Пропустити чи не пропускати додавання стандартного блока з посиланням відписки до HTML-частини листа.
     * 1=пропустити, 0=додати, за замовчуванням 0.
     */
    public function getSkipUnsubscribe(): ?int
    {
        return $this->skipUnsubscribe;
    }

    /**
     * Пропустити чи не пропускати додавання стандартного блока з посиланням відписки до HTML-частини листа.
     * 1=пропустити, 0=додати, за замовчуванням 0.
     *
     * @return $this
     */
    public function setSkipUnsubscribe(?int $skipUnsubscribe): self
    {
        $this->skipUnsubscribe = $skipUnsubscribe;

        return $this;
    }

    /**
     * Заголовок для вибору мови посилання та сторінки відписки.
     */
    public function getGlobalLanguage(): ?string
    {
        return $this->globalLanguage;
    }

    /**
     * Заголовок для вибору мови посилання та сторінки відписки.
     *
     * @return $this
     */
    public function setGlobalLanguage(?string $globalLanguage): self
    {
        $this->globalLanguage = $globalLanguage;

        return $this;
    }

    /**
     * Параметр для вибору [шаблонізатора](https://docs.allymailer.com.ua/ua/template-engines) — або "simple", або
     * "velocity", або "liquid", або "none".
     *
     * @return string|null
     */
    public function getTemplateEngine(): ?string
    {
        return $this->templateEngine;
    }

    /**
     * Параметр для вибору [шаблонізатора](https://docs.allymailer.com.ua/ua/template-engines) — або "simple", або
     * "velocity", або "liquid", або "none".
     *
     * @param string|null $templateEngine Значення: константи `TemplateEngine`.
     *
     * @return $this
     */
    public function setTemplateEngine(?string $templateEngine): self
    {
        $this->templateEngine = $templateEngine;

        return $this;
    }

    /**
     * Об'єкт для передачі глобальних підстановок (наприклад, назва компанії).
     *
     * @return array<string, string>|null
     */
    public function getGlobalSubstitutions(): ?array
    {
        return $this->globalSubstitutions;
    }

    /**
     * Об'єкт для передачі глобальних підстановок (наприклад, назва компанії).
     *
     * @param array<string, string>|null $globalSubstitutions
     *
     * @return $this
     */
    public function setGlobalSubstitutions(?array $globalSubstitutions): self
    {
        $this->globalSubstitutions = $globalSubstitutions;

        return $this;
    }

    /**
     * Об'єкт для передачі метаданих, спільних для всіх отримувачів, у форматі: "key": "value".
     *
     * @return array<string, string>|null
     */
    public function getGlobalMetadata(): ?array
    {
        return $this->globalMetadata;
    }

    /**
     * Об'єкт для передачі метаданих, спільних для всіх отримувачів, у форматі: "key": "value".
     *
     * @param array<string, string>|null $globalMetadata
     *
     * @return $this
     */
    public function setGlobalMetadata(?array $globalMetadata): self
    {
        $this->globalMetadata = $globalMetadata;

        return $this;
    }

    /**
     * Об'єкт, що містить у собі html-, plaintext- і amp-частини листа.
     */
    public function getBody(): BodyObject
    {
        return $this->body;
    }

    /**
     * Об'єкт, що містить у собі html-, plaintext- і amp-частини листа.
     *
     * @return $this
     */
    public function setBody(BodyObject $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Тема листа.
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Тема листа.
     *
     * @return $this
     */
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Email-адреса відправника.
     */
    public function getFromEmail(): ?string
    {
        return $this->fromEmail;
    }

    /**
     * Email-адреса відправника.
     *
     * @return $this
     */
    public function setFromEmail(?string $fromEmail): self
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Ім'я відправника.
     */
    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    /**
     * Ім'я відправника.
     *
     * @return $this
     */
    public function setFromName(?string $fromName): self
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Необов'язкова email-адреса для відповідей (на випадок, якщо відрізняється від адреси відправника)
     */
    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    /**
     * Необов'язкова email-адреса для відповідей (на випадок, якщо відрізняється від адреси відправника)
     *
     * @return $this
     */
    public function setReplyTo(?string $replyTo): self
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * Необов'язкове ім'я для відповідей (якщо вказано email reply_to і ви хочете, щоб відображався не лише цей
     * email, але й ім'я)
     */
    public function getReplyToName(): ?string
    {
        return $this->replyToName;
    }

    /**
     * Необов'язкове ім'я для відповідей (якщо вказано email reply_to і ви хочете, щоб відображався не лише цей
     * email, але й ім'я)
     *
     * @return $this
     */
    public function setReplyToName(?string $replyToName): self
    {
        $this->replyToName = $replyToName;

        return $this;
    }

    /**
     * 1 = відстеження переходів за посиланнями увімкнено (значення за замовчуванням), 0=вимкнено.
     */
    public function getTrackLinks(): ?int
    {
        return $this->trackLinks;
    }

    /**
     * 1 = відстеження переходів за посиланнями увімкнено (значення за замовчуванням), 0=вимкнено.
     *
     * @return $this
     */
    public function setTrackLinks(?int $trackLinks): self
    {
        $this->trackLinks = $trackLinks;

        return $this;
    }

    /**
     * 1 = відстеження прочитань листа увімкнено (значення за замовчуванням), 0 = вимкнено.
     */
    public function getTrackRead(): ?int
    {
        return $this->trackRead;
    }

    /**
     * 1 = відстеження прочитань листа увімкнено (значення за замовчуванням), 0 = вимкнено.
     *
     * @return $this
     */
    public function setTrackRead(?int $trackRead): self
    {
        $this->trackRead = $trackRead;

        return $this;
    }

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список глобальної недоступності, під час надсилання не
     * враховуватимуться дані про недоступність адрес або скарги, отримані під час надсилання іншими користувачами
     * AllyMailer.
     */
    public function getBypassGlobal(): ?int
    {
        return $this->bypassGlobal;
    }

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список глобальної недоступності, під час надсилання не
     * враховуватимуться дані про недоступність адрес або скарги, отримані під час надсилання іншими користувачами
     * AllyMailer.
     *
     * @return $this
     */
    public function setBypassGlobal(?int $bypassGlobal): self
    {
        $this->bypassGlobal = $bypassGlobal;

        return $this;
    }

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список недоступних адрес поточного облікового
     * запису/проєкту.
     */
    public function getBypassUnavailable(): ?int
    {
        return $this->bypassUnavailable;
    }

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список недоступних адрес поточного облікового
     * запису/проєкту.
     *
     * @return $this
     */
    public function setBypassUnavailable(?int $bypassUnavailable): self
    {
        $this->bypassUnavailable = $bypassUnavailable;

        return $this;
    }

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список відписаних від розсилок поточного облікового
     * запису/проєкту.
     */
    public function getBypassUnsubscribed(): ?int
    {
        return $this->bypassUnsubscribed;
    }

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список відписаних від розсилок поточного облікового
     * запису/проєкту.
     *
     * @return $this
     */
    public function setBypassUnsubscribed(?int $bypassUnsubscribed): self
    {
        $this->bypassUnsubscribed = $bypassUnsubscribed;

        return $this;
    }

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список тих, хто поскаржився на обліковий запис/проєкт.
     */
    public function getBypassComplained(): ?int
    {
        return $this->bypassComplained;
    }

    /**
     * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список тих, хто поскаржився на обліковий запис/проєкт.
     *
     * @return $this
     */
    public function setBypassComplained(?int $bypassComplained): self
    {
        $this->bypassComplained = $bypassComplained;

        return $this;
    }

    /**
     * Рядок до 64 символів завдовжки з унікальним ключем запиту.
     */
    public function getIdempotenceKey(): ?string
    {
        return $this->idempotenceKey;
    }

    /**
     * Рядок до 64 символів завдовжки з унікальним ключем запиту.
     *
     * @return $this
     */
    public function setIdempotenceKey(?string $idempotenceKey): self
    {
        $this->idempotenceKey = $idempotenceKey;

        return $this;
    }

    /**
     * Об'єкт, що містить додаткові заголовки листа, максимум 50 заголовків.
     */
    public function getHeaders(): ?HeadersObject
    {
        return $this->headers;
    }

    /**
     * Об'єкт, що містить додаткові заголовки листа, максимум 50 заголовків.
     *
     * @return $this
     */
    public function setHeaders(?HeadersObject $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Необов'язковий масив вкладень.
     *
     * @return list<AttachmentsArrayItem>|null
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    /**
     * Необов'язковий масив вкладень.
     *
     * @param list<AttachmentsArrayItem>|null $attachments
     *
     * @return $this
     */
    public function setAttachments(?array $attachments): self
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * Масив для передачі inline-вкладень, наприклад, для включення зображень у лист замість завантаження їх за
     * посиланням.
     *
     * @return list<InlineAttachmentsArrayItem>|null
     */
    public function getInlineAttachments(): ?array
    {
        return $this->inlineAttachments;
    }

    /**
     * Масив для передачі inline-вкладень, наприклад, для включення зображень у лист замість завантаження їх за
     * посиланням.
     *
     * @param list<InlineAttachmentsArrayItem>|null $inlineAttachments
     *
     * @return $this
     */
    public function setInlineAttachments(?array $inlineAttachments): self
    {
        $this->inlineAttachments = $inlineAttachments;

        return $this;
    }

    /**
     * Додаткові опції.
     */
    public function getOptions(): ?MessageObjectOptions
    {
        return $this->options;
    }

    /**
     * Додаткові опції.
     *
     * @return $this
     */
    public function setOptions(?MessageObjectOptions $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'recipients' => \array_map(static function (MessageObjectRecipientsItem $item) { return Data::object($item->toArray()); }, $this->recipients),
            'template_id' => $this->templateId,
            'tags' => $this->tags,
            'skip_unsubscribe' => $this->skipUnsubscribe,
            'global_language' => $this->globalLanguage,
            'template_engine' => $this->templateEngine,
            'global_substitutions' => Data::object($this->globalSubstitutions),
            'global_metadata' => Data::object($this->globalMetadata),
            'body' => Data::object($this->body->toArray()),
            'subject' => $this->subject,
            'from_email' => $this->fromEmail,
            'from_name' => $this->fromName,
            'reply_to' => $this->replyTo,
            'reply_to_name' => $this->replyToName,
            'track_links' => $this->trackLinks,
            'track_read' => $this->trackRead,
            'bypass_global' => $this->bypassGlobal,
            'bypass_unavailable' => $this->bypassUnavailable,
            'bypass_unsubscribed' => $this->bypassUnsubscribed,
            'bypass_complained' => $this->bypassComplained,
            'idempotence_key' => $this->idempotenceKey,
            'headers' => null === $this->headers ? null : Data::object($this->headers->toArray()),
            'attachments' => null === $this->attachments ? null : \array_map(static function (AttachmentsArrayItem $item) { return Data::object($item->toArray()); }, $this->attachments),
            'inline_attachments' => null === $this->inlineAttachments ? null : \array_map(static function (InlineAttachmentsArrayItem $item) { return Data::object($item->toArray()); }, $this->inlineAttachments),
            'options' => null === $this->options ? null : Data::object($this->options->toArray()),
        ], static function ($value): bool {
            return $value !== null;
        });
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return Data::object($this->toArray());
    }
}
