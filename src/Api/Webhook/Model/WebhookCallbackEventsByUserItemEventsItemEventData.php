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
    public function __construct(
        /**
         * Ідентифікатор завдання, раніше повернутий методом
         * [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send). Присутній лише якщо
         * event_name="transactional_email_status".
         * Приклад: `1ZymBc-00041N-9X`.
         */
        public ?string $jobId = null,
        /**
         * Метадані, раніше передані методом [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send) у
         * полі recipients.metadata або global_metadata. Присутні лише якщо event_name="transactional_email_status".
         * @var array<string, string>|null
         */
        public ?array $metadata = null,
        /**
         * Email, на який було здійснено надсилання. Присутній лише якщо event_name="transactional_email_status".
         */
        public ?string $email = null,
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
         */
        public EmailStatus|string|null $status = null,
        /**
         * Дата й час події в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс". Присутній лише якщо
         * event_name="transactional_email_status".
         * Приклад: `2020-12-24 16:05:58`.
         */
        public ?string $eventTime = null,
        /**
         * URL у разі статусів "opened" і "clicked". Присутній лише якщо event_name="transactional_email_status".
         */
        public ?string $url = null,
        /**
         * Об'єкт з додатковою інформацією про доставку. Присутній лише якщо властивість delivery_info під час
         * встановлення webhook дорівнювала 1 і якщо event_name="transactional_email_status".
         */
        public ?WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo $deliveryInfo = null,
        /**
         * Дата й час спам-блока в часовому поясі UTC у форматі "РРРР-ММ-ДД гг:хх:сс". Присутній лише якщо
         * event_name="transactional_spam_block".
         * Приклад: `2020-12-24 16:05:58`.
         */
        public ?string $blockTime = null,
        /**
         * Тип спам-блока — заблоковано або один відправляючий SMTP, або одразу багато. У разі блокування одиночного SMTP
         * із загального пулу AllyMailer пробуватиме ще декілька. Властивість присутня лише якщо
         * event_name="transactional_spam_block".
         */
        public BlockType|string|null $blockType = null,
        /**
         * Домен, що заблокував надсилання. Властивість присутня лише якщо event_name="transactional_spam_block".
         * Приклад: `example.com`.
         */
        public ?string $domain = null,
        /**
         * Кількість заблокованих вихідних SMTP. Властивість присутня лише якщо event_name="transactional_spam_block".
         */
        public ?int $sMTPBlocksCount = null,
        /**
         * Це подія блокування чи розблокування. Властивість присутня лише якщо event_name="transactional_spam_block".
         */
        public DomainStatus|string|null $domainStatus = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            jobId: Data::string($data['job_id'] ?? null),
            metadata: Data::map($data['metadata'] ?? null, static fn ($item) => Data::string($item) ?? ''),
            email: Data::string($data['email'] ?? null),
            status: Data::enum(EmailStatus::class, Data::string($data['status'] ?? null)),
            eventTime: Data::string($data['event_time'] ?? null),
            url: Data::string($data['url'] ?? null),
            deliveryInfo: Data::model(WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo::class, $data['delivery_info'] ?? null),
            blockTime: Data::string($data['block_time'] ?? null),
            blockType: Data::enum(BlockType::class, Data::string($data['block_type'] ?? null)),
            domain: Data::string($data['domain'] ?? null),
            sMTPBlocksCount: Data::int($data['SMTP_blocks_count'] ?? null),
            domainStatus: Data::enum(DomainStatus::class, Data::string($data['domain_status'] ?? null)),
        );
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
            'status' => Data::value($this->status),
            'event_time' => $this->eventTime,
            'url' => $this->url,
            'delivery_info' => null === $this->deliveryInfo ? null : Data::object($this->deliveryInfo->toArray()),
            'block_time' => $this->blockTime,
            'block_type' => Data::value($this->blockType),
            'domain' => $this->domain,
            'SMTP_blocks_count' => $this->sMTPBlocksCount,
            'domain_status' => Data::value($this->domainStatus),
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
