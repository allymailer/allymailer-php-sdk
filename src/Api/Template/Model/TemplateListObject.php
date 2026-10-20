<?php

declare(strict_types=1);

namespace AllyMailer\Api\Template\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\AttachmentsArrayItem;
use AllyMailer\Common\Model\BodyObject;
use AllyMailer\Common\Model\HeadersObject;
use AllyMailer\Common\Model\InlineAttachmentsArrayItem;
use AllyMailer\Common\Model\TemplateEngine;

/**
 * TemplateListObject
 */
final class TemplateListObject implements \JsonSerializable
{
    public function __construct(
        /**
         * Унікальний ідентифікатор шаблону.
         */
        public ?string $id = null,
        /**
         * Назва шаблону.
         */
        public ?string $name = null,
        /**
         * Тип редактора шаблону у вебінтерфейсі, "html" або "visual". За замовчуванням — "html". Створення шаблонів із
         * типом редактора "visual" можливе лише через вебінтерфейс.
         */
        public EditorType|string|null $editorType = null,
        /**
         * Параметр для вибору [шаблонізатора](https://docs.allymailer.com.ua/en/template-engines) — або "simple", або
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
         * Об'єкт, що містить у собі html-, plaintext- і amp-частини листа. Або html-, або plaintext-частина має бути
         * присутня обов'язково.
         */
        public ?BodyObject $body = null,
        /**
         * Тема листа.
         * Приклад: `AllyMailer test email `.
         */
        public ?string $subject = null,
        /**
         * Email-адреса відправника.
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
         * Час створення шаблону в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс"
         */
        public ?string $created = null,
        /**
         * Унікальний ідентифікатор користувача.
         * Приклад: `11344`.
         */
        public ?int $userId = null,
        /**
         * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
         * Приклад: `6123462132634`.
         */
        public ?string $projectId = null,
        /**
         * Назва проєкту, унікальна в межах облікового запису користувача.
         * Приклад: `Project 1A`.
         */
        public ?string $projectName = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Data::string($data['id'] ?? null),
            name: Data::string($data['name'] ?? null),
            editorType: Data::enum(EditorType::class, Data::string($data['editor_type'] ?? null)),
            templateEngine: Data::enum(TemplateEngine::class, Data::string($data['template_engine'] ?? null)),
            globalSubstitutions: Data::map($data['global_substitutions'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            globalMetadata: Data::map($data['global_metadata'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            body: Data::model(BodyObject::class, $data['body'] ?? null),
            subject: Data::string($data['subject'] ?? null),
            fromEmail: Data::string($data['from_email'] ?? null),
            fromName: Data::string($data['from_name'] ?? null),
            replyTo: Data::string($data['reply_to'] ?? null),
            replyToName: Data::string($data['reply_to_name'] ?? null),
            trackLinks: Data::int($data['track_links'] ?? null),
            trackRead: Data::int($data['track_read'] ?? null),
            headers: Data::model(HeadersObject::class, $data['headers'] ?? null),
            attachments: Data::list($data['attachments'] ?? null, static fn ($item) => AttachmentsArrayItem::fromArray(Data::array($item) ?? [])),
            inlineAttachments: Data::list($data['inline_attachments'] ?? null, static fn ($item) => InlineAttachmentsArrayItem::fromArray(Data::array($item) ?? [])),
            created: Data::string($data['created'] ?? null),
            userId: Data::int($data['user_id'] ?? null),
            projectId: Data::string($data['project_id'] ?? null),
            projectName: Data::string($data['project_name'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'editor_type' => Data::value($this->editorType),
            'template_engine' => Data::value($this->templateEngine),
            'global_substitutions' => Data::object($this->globalSubstitutions),
            'global_metadata' => Data::object($this->globalMetadata),
            'body' => null === $this->body ? null : Data::object($this->body->toArray()),
            'subject' => $this->subject,
            'from_email' => $this->fromEmail,
            'from_name' => $this->fromName,
            'reply_to' => $this->replyTo,
            'reply_to_name' => $this->replyToName,
            'track_links' => $this->trackLinks,
            'track_read' => $this->trackRead,
            'headers' => null === $this->headers ? null : Data::object($this->headers->toArray()),
            'attachments' => null === $this->attachments ? null : \array_map(static fn (AttachmentsArrayItem $item) => Data::object($item->toArray()), $this->attachments),
            'inline_attachments' => null === $this->inlineAttachments ? null : \array_map(static fn (InlineAttachmentsArrayItem $item) => Data::object($item->toArray()), $this->inlineAttachments),
            'created' => $this->created,
            'user_id' => $this->userId,
            'project_id' => $this->projectId,
            'project_name' => $this->projectName,
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
