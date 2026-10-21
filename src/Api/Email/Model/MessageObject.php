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
    public function __construct(
        /**
         * Масив об'єктів з email-адресами, підстановками та метаданими отримувачів.
         * @var list<MessageObjectRecipientsItem>
         */
        public array $recipients,
        /**
         * Об'єкт, що містить у собі html-, plaintext- і amp-частини листа. Або html-, або plaintext-частина має бути
         * присутня обов'язково.
         */
        public BodyObject $body,
        /**
         * Тема листа.
         * Приклад: `AllyMailer test email `.
         */
        public string $subject,
        /**
         * Унікальний ідентифікатор шаблону, створеного раніше методом
         * [template/set](https://docs.allymailer.com.ua/ua/web-api-ref#template-set). Якщо вказано, то поля шаблону
         * підставляються замість пропущених полів email/send. Наприклад, якщо в email/send не вказано body — береться
         * тіло листа із шаблону, а якщо не вказано subject — береться тема із шаблону.
         * Приклад: `00000000-0000-0000-0000-000000000000`.
         */
        public ?string $templateId = null,
        /**
         * Масив із рядків, до 100 символів у кожному. Максимум 4 рядки в масиві, рядки мають бути унікальними. Для
         * кожного облікового запису/проєкту дозволено не більше ніж 10 000 міток, у разі перевищення метод email/send
         * повертатиме помилку. Мітки можуть використовуватися для категоризації листів за обраними вами критеріями.
         * Мітки передаються методами event-dump.
         * @var list<string>|null
         */
        public ?array $tags = null,
        /**
         * Пропустити чи не пропускати додавання стандартного блока з посиланням відписки до HTML-частини листа.
         * 1=пропустити, 0=додати, за замовчуванням 0. Для использования skip_unsubscribe=1 вам надо [попросить
         * техподдержку](https://cp.allymailer.com/ru/support) включить такую возможность.
         * Допустимі значення: `0`, `1`.
         * Приклад: `0`.
         */
        public ?int $skipUnsubscribe = null,
        /**
         * Заголовок для вибору мови посилання та сторінки відписки. Припустимі значення "be", "de", "en", "es", "fr",
         * "it", "pl", "pt", "ru", "ua", "kz".
         * Приклад: `en`.
         */
        public ?string $globalLanguage = null,
        /**
         * Параметр для вибору [шаблонізатора](https://docs.allymailer.com.ua/ua/template-engines) — або "simple", або
         * "velocity", або "liquid", або "none". За замовчуванням — "simple".
         */
        public TemplateEngine|string|null $templateEngine = null,
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
         * @var array<string, string>|null
         */
        public ?array $globalSubstitutions = null,
        /**
         * Об'єкт для передачі метаданих, спільних для всіх отримувачів, у форматі: "key": "value". Максимальна кількість
         * ключів: 10; максимальна довжина ключа: 64 символи; максимальна довжина значення ключа: 1024 символи. Метадані
         * передаються під час виклику [webhook](https://docs.allymailer.com.ua/ua/web-api-ref#webhook). Для групування
         * листів в одну розсилку може використовуватися системний ключ "campaign_id" зі значенням у вигляді невід'ємного
         * десяткового цілого до 128 біт або UUID вигляду "c7703772-453e-4c77-a9ae-9a1b94051b5a". Неправильні значення
         * будуть прирівняні до '0'
         * @var array<string, string>|null
         */
        public ?array $globalMetadata = null,
        /**
         * Email-адреса відправника. Обов'язковий лише за порожнього template_id.
         * Приклад: `email@example.com`.
         */
        public ?string $fromEmail = null,
        /**
         * Ім'я відправника.
         * Приклад: `John Smith`.
         */
        public ?string $fromName = null,
        /**
         * Необов'язкова email-адреса для відповідей (на випадок, якщо відрізняється від адреси відправника)
         * Приклад: `email@example.com`.
         */
        public ?string $replyTo = null,
        /**
         * Необов'язкове ім'я для відповідей (якщо вказано email reply_to і ви хочете, щоб відображався не лише цей
         * email, але й ім'я)
         * Приклад: `John Smith`.
         */
        public ?string $replyToName = null,
        /**
         * 1 = відстеження переходів за посиланнями увімкнено (значення за замовчуванням), 0=вимкнено. Для використання
         * track_links = 0 вам потрібно [попросити техпідтримку](https://cp.allymailer.com/ua/support) увімкнути таку
         * можливість.
         * Допустимі значення: `0`, `1`.
         * Приклад: `0`.
         */
        public ?int $trackLinks = null,
        /**
         * 1 = відстеження прочитань листа увімкнено (значення за замовчуванням), 0 = вимкнено. Для використання
         * track_read = 0 вам потрібно [попросити техпідтримку](https://cp.allymailer.com/ua/support) увімкнути таку
         * можливість.
         * Допустимі значення: `0`, `1`.
         * Приклад: `0`.
         */
        public ?int $trackRead = null,
        /**
         * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список глобальної недоступності, під час надсилання не
         * враховуватимуться дані про недоступність адрес або скарги, отримані під час надсилання іншими користувачами
         * AllyMailer. Для деяких системних записів може бути заборонено
         * Допустимі значення: `0`, `1`.
         * Приклад: `0`.
         */
        public ?int $bypassGlobal = null,
        /**
         * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список недоступних адрес поточного облікового
         * запису/проєкту. Указання 1 можливе лише за одночасного вказання bypass_global=1.
         * Допустимі значення: `0`, `1`.
         * Приклад: `0`.
         */
        public ?int $bypassUnavailable = null,
        /**
         * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список відписаних від розсилок поточного облікового
         * запису/проєкту. Указання 1 можливе лише за одночасного вказання bypass_global=1. Параметр доступний лише тим
         * користувачам, яким [техпідтримка](https://cp.allymailer.com/ua/support) схвалила вимкнення посилання відписки.
         * Допустимі значення: `0`, `1`.
         * Приклад: `0`.
         */
        public ?int $bypassUnsubscribed = null,
        /**
         * (0 або 1, за замовчуванням 0) Значення 1=ігнорувати список тих, хто поскаржився на обліковий запис/проєкт.
         * Указання 1 можливе лише за одночасного вказання bypass_global=1. Параметр доступний лише тим користувачам,
         * яким [техпідтримка](https://cp.allymailer.com/ua/support) схвалила вимкнення посилання відписки.
         * Допустимі значення: `0`, `1`.
         * Приклад: `0`.
         */
        public ?int $bypassComplained = null,
        /**
         * Рядок до 64 символів завдовжки з унікальним ключем запиту. Може використовуватися для запобігання випадковому
         * дублюванню листів. У разі повторного надсилання запиту з тим самим ключем протягом хвилини запит буде
         * відхилено. Може створюватися автоматично для кожного листа; щоб увімкнути автоматичну генерацію ключа,
         * зв'яжіться з [техпідтримкою](https://cp.allymailer.com/ua/support).
         * Приклад: `SG1VsbG68sIH2dvc5mx890kIQ`.
         */
        public ?string $idempotenceKey = null,
        /**
         * Об'єкт, що містить додаткові заголовки листа, максимум 50 заголовків. Префікс “X-” в імені заголовка
         * обов'язковий, заголовки без нього будуть проігноровані, наприклад X-ALLYMAILER-Global-Language,
         * X-ALLYMAILER-Template-Engine. Стандартні заголовки "To", "CC", "BCC" передаються без префікса "X-", але
         * обробляються спеціальним чином, тому мають низку обмежень, докладніше про це можна прочитати
         * [тут](/cc-and-bcc). Також якщо [техпідтримка](https://cp.allymailer.com/ua/support) схвалила вам вимкнення
         * посилання відписки, то ви також можете передавати заголовки List-Unsubscribe, List-Subscribe, List-Help,
         * List-Owner, List-Archive, In-Reply-To і References.
         */
        public ?HeadersObject $headers = null,
        /**
         * Необов'язковий масив вкладень.
         * @var list<AttachmentsArrayItem>|null
         */
        public ?array $attachments = null,
        /**
         * Масив для передачі inline-вкладень, наприклад, для включення зображень у лист замість завантаження їх за
         * посиланням.
         * @var list<InlineAttachmentsArrayItem>|null
         */
        public ?array $inlineAttachments = null,
        /**
         * Додаткові опції.
         */
        public ?MessageObjectOptions $options = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            recipients: Data::list($data['recipients'] ?? null, static fn ($item) => MessageObjectRecipientsItem::fromArray(Data::array($item) ?? [])) ?? [],
            body: BodyObject::fromArray(Data::array($data['body'] ?? null) ?? []),
            subject: Data::string($data['subject'] ?? null) ?? '',
            templateId: Data::string($data['template_id'] ?? null),
            tags: Data::list($data['tags'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            skipUnsubscribe: Data::int($data['skip_unsubscribe'] ?? null),
            globalLanguage: Data::string($data['global_language'] ?? null),
            templateEngine: Data::enum(TemplateEngine::class, Data::string($data['template_engine'] ?? null)),
            globalSubstitutions: Data::map($data['global_substitutions'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            globalMetadata: Data::map($data['global_metadata'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            fromEmail: Data::string($data['from_email'] ?? null),
            fromName: Data::string($data['from_name'] ?? null),
            replyTo: Data::string($data['reply_to'] ?? null),
            replyToName: Data::string($data['reply_to_name'] ?? null),
            trackLinks: Data::int($data['track_links'] ?? null),
            trackRead: Data::int($data['track_read'] ?? null),
            bypassGlobal: Data::int($data['bypass_global'] ?? null),
            bypassUnavailable: Data::int($data['bypass_unavailable'] ?? null),
            bypassUnsubscribed: Data::int($data['bypass_unsubscribed'] ?? null),
            bypassComplained: Data::int($data['bypass_complained'] ?? null),
            idempotenceKey: Data::string($data['idempotence_key'] ?? null),
            headers: Data::model(HeadersObject::class, $data['headers'] ?? null),
            attachments: Data::list($data['attachments'] ?? null, static fn ($item) => AttachmentsArrayItem::fromArray(Data::array($item) ?? [])),
            inlineAttachments: Data::list($data['inline_attachments'] ?? null, static fn ($item) => InlineAttachmentsArrayItem::fromArray(Data::array($item) ?? [])),
            options: Data::model(MessageObjectOptions::class, $data['options'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'recipients' => \array_map(static fn (MessageObjectRecipientsItem $item) => Data::object($item->toArray()), $this->recipients),
            'template_id' => $this->templateId,
            'tags' => $this->tags,
            'skip_unsubscribe' => $this->skipUnsubscribe,
            'global_language' => $this->globalLanguage,
            'template_engine' => Data::value($this->templateEngine),
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
            'attachments' => null === $this->attachments ? null : \array_map(static fn (AttachmentsArrayItem $item) => Data::object($item->toArray()), $this->attachments),
            'inline_attachments' => null === $this->inlineAttachments ? null : \array_map(static fn (InlineAttachmentsArrayItem $item) => Data::object($item->toArray()), $this->inlineAttachments),
            'options' => null === $this->options ? null : Data::object($this->options->toArray()),
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    public function jsonSerialize(): mixed
    {
        return Data::object($this->toArray());
    }
}
