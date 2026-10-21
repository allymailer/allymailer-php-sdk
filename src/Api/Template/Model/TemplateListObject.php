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
    /**
     * Унікальний ідентифікатор шаблону.
     *
     * @var string|null
     */
    private $id;

    /**
     * Назва шаблону.
     *
     * @var string|null
     */
    private $name;

    /**
     * Тип редактора шаблону у вебінтерфейсі, "html" або "visual". За замовчуванням — "html". Створення шаблонів із
     * типом редактора "visual" можливе лише через вебінтерфейс.
     * Значення: константи `EditorType`.
     *
     * @var string|null
     */
    private $editorType;

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
     * @var BodyObject|null
     */
    private $body;

    /**
     * Тема листа.
     * Приклад: `AllyMailer test email `.
     *
     * @var string|null
     */
    private $subject;

    /**
     * Email-адреса відправника.
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
     * Час створення шаблону в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс"
     *
     * @var string|null
     */
    private $created;

    /**
     * Унікальний ідентифікатор користувача.
     * Приклад: `11344`.
     *
     * @var int|null
     */
    private $userId;

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     * Приклад: `6123462132634`.
     *
     * @var string|null
     */
    private $projectId;

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     * Приклад: `Project 1A`.
     *
     * @var string|null
     */
    private $projectName;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->id = Data::string($data['id'] ?? null);
        $model->name = Data::string($data['name'] ?? null);
        $model->editorType = Data::string($data['editor_type'] ?? null);
        $model->templateEngine = Data::string($data['template_engine'] ?? null);
        $model->globalSubstitutions = Data::map($data['global_substitutions'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->globalMetadata = Data::map($data['global_metadata'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->body = Data::model(BodyObject::class, $data['body'] ?? null);
        $model->subject = Data::string($data['subject'] ?? null);
        $model->fromEmail = Data::string($data['from_email'] ?? null);
        $model->fromName = Data::string($data['from_name'] ?? null);
        $model->replyTo = Data::string($data['reply_to'] ?? null);
        $model->replyToName = Data::string($data['reply_to_name'] ?? null);
        $model->trackLinks = Data::int($data['track_links'] ?? null);
        $model->trackRead = Data::int($data['track_read'] ?? null);
        $model->headers = Data::model(HeadersObject::class, $data['headers'] ?? null);
        $model->attachments = Data::list($data['attachments'] ?? null, static function ($item) { return AttachmentsArrayItem::fromArray(Data::array($item) ?? []); });
        $model->inlineAttachments = Data::list($data['inline_attachments'] ?? null, static function ($item) { return InlineAttachmentsArrayItem::fromArray(Data::array($item) ?? []); });
        $model->created = Data::string($data['created'] ?? null);
        $model->userId = Data::int($data['user_id'] ?? null);
        $model->projectId = Data::string($data['project_id'] ?? null);
        $model->projectName = Data::string($data['project_name'] ?? null);

        return $model;
    }

    /**
     * Унікальний ідентифікатор шаблону.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Унікальний ідентифікатор шаблону.
     *
     * @return $this
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Назва шаблону.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Назва шаблону.
     *
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Тип редактора шаблону у вебінтерфейсі, "html" або "visual".
     *
     * @return string|null
     */
    public function getEditorType(): ?string
    {
        return $this->editorType;
    }

    /**
     * Тип редактора шаблону у вебінтерфейсі, "html" або "visual".
     *
     * @param string|null $editorType Значення: константи `EditorType`.
     *
     * @return $this
     */
    public function setEditorType(?string $editorType): self
    {
        $this->editorType = $editorType;

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
    public function getBody(): ?BodyObject
    {
        return $this->body;
    }

    /**
     * Об'єкт, що містить у собі html-, plaintext- і amp-частини листа.
     *
     * @return $this
     */
    public function setBody(?BodyObject $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Тема листа.
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * Тема листа.
     *
     * @return $this
     */
    public function setSubject(?string $subject): self
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
     * Час створення шаблону в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс"
     */
    public function getCreated(): ?string
    {
        return $this->created;
    }

    /**
     * Час створення шаблону в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс"
     *
     * @return $this
     */
    public function setCreated(?string $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Унікальний ідентифікатор користувача.
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * Унікальний ідентифікатор користувача.
     *
     * @return $this
     */
    public function setUserId(?int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     */
    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    /**
     * Унікальний ідентифікатор проєкту, ASCII-рядок до 36 символів завдовжки.
     *
     * @return $this
     */
    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     */
    public function getProjectName(): ?string
    {
        return $this->projectName;
    }

    /**
     * Назва проєкту, унікальна в межах облікового запису користувача.
     *
     * @return $this
     */
    public function setProjectName(?string $projectName): self
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'editor_type' => $this->editorType,
            'template_engine' => $this->templateEngine,
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
            'attachments' => null === $this->attachments ? null : \array_map(static function (AttachmentsArrayItem $item) { return Data::object($item->toArray()); }, $this->attachments),
            'inline_attachments' => null === $this->inlineAttachments ? null : \array_map(static function (InlineAttachmentsArrayItem $item) { return Data::object($item->toArray()); }, $this->inlineAttachments),
            'created' => $this->created,
            'user_id' => $this->userId,
            'project_id' => $this->projectId,
            'project_name' => $this->projectName,
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
