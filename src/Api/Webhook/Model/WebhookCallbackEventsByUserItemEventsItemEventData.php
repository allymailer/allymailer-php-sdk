<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\EmailStatus;

/**
 * Об'єкт з різними властивостями події, що залежать від поля "event_name". Нижче перелічено всі можливі
 * властивості, спочатку для події "transactional_email_status", потім для події "transactional_spam_block".
 */
final class WebhookCallbackEventsByUserItemEventsItemEventData implements \JsonSerializable
{
    /**
     * Ідентифікатор завдання, раніше повернутий методом
     * [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send). Присутній лише якщо
     * event_name="transactional_email_status".
     * Приклад: `1ZymBc-00041N-9X`.
     *
     * @var string|null
     */
    private $jobId;

    /**
     * Метадані, раніше передані методом [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send) у
     * полі recipients.metadata або global_metadata. Присутні лише якщо event_name="transactional_email_status".
     *
     * @var array<string, string>|null
     */
    private $metadata;

    /**
     * Email, на який було здійснено надсилання. Присутній лише якщо event_name="transactional_email_status".
     *
     * @var string|null
     */
    private $email;

    /**
     * Статус доставки листа. Присутній лише якщо event_name="transactional_email_status". Набуває одного з таких
     * значень:
     *
     * __accepted__ — повідомлення прийнято, але ще не надіслано.
     *
     * __sent__ — повідомлення надіслано, але ще не доставлено.
     *
     * __delivered__ — повідомлення доставлено. Може змінитися на “opened”, “clicked”, “unsubscribed”, “subscribed”
     * або “spam”.
     *
     * __opened__ — повідомлення доставлено й зареєстровано його прочитання. Може змінитися на “clicked”,
     * “unsubscribed”, “subscribed” або “spam”.
     *
     * __clicked__ — повідомлення доставлено, прочитано, було зареєстровано перехід за одним з посилань у листі. Може
     * змінитися на “unsubscribed”, “subscribed” або “spam”.
     *
     * __unsubscribed__ — повідомлення було доставлено отримувачу й прочитано ним, але користувач відписався за
     * посиланням у листі. Може змінитися на “subscribed”.
     *
     * __subscribed__ — повідомлення було доставлено отримувачу й прочитано ним, але користувач відписався, а потім
     * знову підписався за посиланням у листі. Може змінитися на “unsubscribed”.
     *
     * __soft_bounced__ — тимчасова недоставка повідомлення. AllyMailer продовжує спроби доставки протягом 2 діб. У
     * разі успішної доставки лист перейде у статус “delivered”, у разі неуспішної — у “hard_bounced”.
     *
     * __hard_bounced__ — доставка не вдалася, спроб доставки більше не буде. Статус остаточний. Можливих причин
     * невдалої доставки безліч, для їх аналізу можна використати текст відповіді SMTP-сервера з поля
     * delivery_info.destination_response або нашу внутрішню класифікацію помилок з поля
     * delivery_info.delivery_status.
     *
     * __spam__ — повідомлення доставлено, але позначено як “спам” отримувачем. Статус остаточний. Ось деякі домени,
     * від яких AllyMailer може отримати й обробити скаргу про спам (використовуючи технологію FBL): mail.ru,
     * msn.com, outlook.com, hotmail.com, live.com, ukr.net, yahoo.com, aol.com.
     * Значення: константи `EmailStatus`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Дата й час події в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс". Присутній лише якщо
     * event_name="transactional_email_status".
     * Приклад: `2020-12-24 16:05:58`.
     *
     * @var string|null
     */
    private $eventTime;

    /**
     * URL у разі статусів "opened" і "clicked". Присутній лише якщо event_name="transactional_email_status".
     *
     * @var string|null
     */
    private $url;

    /**
     * Об'єкт з додатковою інформацією про доставку. Присутній лише якщо властивість delivery_info під час
     * встановлення webhook дорівнювала 1 і якщо event_name="transactional_email_status".
     *
     * @var WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo|null
     */
    private $deliveryInfo;

    /**
     * Дата й час спам-блока в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс". Присутній лише якщо
     * event_name="transactional_spam_block".
     * Приклад: `2020-12-24 16:05:58`.
     *
     * @var string|null
     */
    private $blockTime;

    /**
     * Тип спам-блока — заблоковано або один відправляючий SMTP, або одразу багато. У разі блокування одиночного SMTP
     * із загального пулу AllyMailer пробуватиме ще декілька. Властивість присутня лише якщо
     * event_name="transactional_spam_block".
     * Значення: константи `BlockType`.
     *
     * @var string|null
     */
    private $blockType;

    /**
     * Домен, що заблокував надсилання. Властивість присутня лише якщо event_name="transactional_spam_block".
     * Приклад: `example.com`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Кількість заблокованих вихідних SMTP. Властивість присутня лише якщо event_name="transactional_spam_block".
     *
     * @var int|null
     */
    private $sMTPBlocksCount;

    /**
     * Це подія блокування чи розблокування. Властивість присутня лише якщо event_name="transactional_spam_block".
     * Значення: константи `DomainStatus`.
     *
     * @var string|null
     */
    private $domainStatus;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->jobId = Data::string($data['job_id'] ?? null);
        $model->metadata = Data::map($data['metadata'] ?? null, static function ($item) { return Data::string($item) ?? ''; });
        $model->email = Data::string($data['email'] ?? null);
        $model->status = Data::string($data['status'] ?? null);
        $model->eventTime = Data::string($data['event_time'] ?? null);
        $model->url = Data::string($data['url'] ?? null);
        $model->deliveryInfo = Data::model(WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo::class, $data['delivery_info'] ?? null);
        $model->blockTime = Data::string($data['block_time'] ?? null);
        $model->blockType = Data::string($data['block_type'] ?? null);
        $model->domain = Data::string($data['domain'] ?? null);
        $model->sMTPBlocksCount = Data::int($data['SMTP_blocks_count'] ?? null);
        $model->domainStatus = Data::string($data['domain_status'] ?? null);

        return $model;
    }

    /**
     * Ідентифікатор завдання, раніше повернутий методом
     * [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send).
     */
    public function getJobId(): ?string
    {
        return $this->jobId;
    }

    /**
     * Ідентифікатор завдання, раніше повернутий методом
     * [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send).
     *
     * @return $this
     */
    public function setJobId(?string $jobId): self
    {
        $this->jobId = $jobId;

        return $this;
    }

    /**
     * Метадані, раніше передані методом [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send) у
     * полі recipients.metadata або global_metadata.
     *
     * @return array<string, string>|null
     */
    public function getMetadata(): ?array
    {
        return $this->metadata;
    }

    /**
     * Метадані, раніше передані методом [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send) у
     * полі recipients.metadata або global_metadata.
     *
     * @param array<string, string>|null $metadata
     *
     * @return $this
     */
    public function setMetadata(?array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Email, на який було здійснено надсилання.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Email, на який було здійснено надсилання.
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Статус доставки листа.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Статус доставки листа.
     *
     * @param string|null $status Значення: константи `EmailStatus`.
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Дата й час події в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     */
    public function getEventTime(): ?string
    {
        return $this->eventTime;
    }

    /**
     * Дата й час події в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     *
     * @return $this
     */
    public function setEventTime(?string $eventTime): self
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    /**
     * URL у разі статусів "opened" і "clicked".
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * URL у разі статусів "opened" і "clicked".
     *
     * @return $this
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Об'єкт з додатковою інформацією про доставку.
     */
    public function getDeliveryInfo(): ?WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo
    {
        return $this->deliveryInfo;
    }

    /**
     * Об'єкт з додатковою інформацією про доставку.
     *
     * @return $this
     */
    public function setDeliveryInfo(?WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo $deliveryInfo): self
    {
        $this->deliveryInfo = $deliveryInfo;

        return $this;
    }

    /**
     * Дата й час спам-блока в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     */
    public function getBlockTime(): ?string
    {
        return $this->blockTime;
    }

    /**
     * Дата й час спам-блока в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс".
     *
     * @return $this
     */
    public function setBlockTime(?string $blockTime): self
    {
        $this->blockTime = $blockTime;

        return $this;
    }

    /**
     * Тип спам-блока — заблоковано або один відправляючий SMTP, або одразу багато.
     *
     * @return string|null
     */
    public function getBlockType(): ?string
    {
        return $this->blockType;
    }

    /**
     * Тип спам-блока — заблоковано або один відправляючий SMTP, або одразу багато.
     *
     * @param string|null $blockType Значення: константи `BlockType`.
     *
     * @return $this
     */
    public function setBlockType(?string $blockType): self
    {
        $this->blockType = $blockType;

        return $this;
    }

    /**
     * Домен, що заблокував надсилання.
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Домен, що заблокував надсилання.
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Кількість заблокованих вихідних SMTP.
     */
    public function getSMTPBlocksCount(): ?int
    {
        return $this->sMTPBlocksCount;
    }

    /**
     * Кількість заблокованих вихідних SMTP.
     *
     * @return $this
     */
    public function setSMTPBlocksCount(?int $sMTPBlocksCount): self
    {
        $this->sMTPBlocksCount = $sMTPBlocksCount;

        return $this;
    }

    /**
     * Це подія блокування чи розблокування.
     *
     * @return string|null
     */
    public function getDomainStatus(): ?string
    {
        return $this->domainStatus;
    }

    /**
     * Це подія блокування чи розблокування.
     *
     * @param string|null $domainStatus Значення: константи `DomainStatus`.
     *
     * @return $this
     */
    public function setDomainStatus(?string $domainStatus): self
    {
        $this->domainStatus = $domainStatus;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'job_id' => $this->jobId,
            'metadata' => Data::object($this->metadata),
            'email' => $this->email,
            'status' => $this->status,
            'event_time' => $this->eventTime,
            'url' => $this->url,
            'delivery_info' => null === $this->deliveryInfo ? null : Data::object($this->deliveryInfo->toArray()),
            'block_time' => $this->blockTime,
            'block_type' => $this->blockType,
            'domain' => $this->domain,
            'SMTP_blocks_count' => $this->sMTPBlocksCount,
            'domain_status' => $this->domainStatus,
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
