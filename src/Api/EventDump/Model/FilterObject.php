<?php

declare(strict_types=1);

namespace AllyMailer\Api\EventDump\Model;

use AllyMailer\Client\Data;
use AllyMailer\Common\Model\EmailStatus;

/**
 * Об'єкт із властивостями фільтра дампа подій.
 */
final class FilterObject implements \JsonSerializable
{
    /**
     * Ідентифікатор завдання, раніше повернутий методом
     * [email/send](https://docs.allymailer.com.ua/ua/web-api-ref#email-send).
     * Приклад: `1ZymBc-00041N-9X`.
     *
     * @var string|null
     */
    private $jobId;

    /**
     * Статус email. Можна вказати одне з таких значень:
     *
     * __accepted__ — повідомлення прийнято, але ще не надіслано.
     *
     * __sent__ — повідомлення надіслано, але ще не доставлено.
     *
     * __delivered__ — повідомлення доставлено.
     *
     * __opened__ — повідомлення доставлено й зареєстровано його прочитання.
     *
     * __clicked__ — повідомлення доставлено, прочитано, було зареєстровано перехід за одним з посилань у листі.
     *
     * __unsubscribed__ — повідомлення було доставлено отримувачу й прочитано ним, але користувач відписався за
     * посиланням у листі.
     *
     * __subscribed__ — повідомлення було доставлено отримувачу й прочитано ним, але користувач відписався, а потім
     * знову підписався за посиланням у листі.
     *
     * __soft_bounced__ — тимчасова недоставка повідомлення. AllyMailer продовжує спроби доставки протягом 2 діб.
     *
     * __hard_bounced__ — доставка не вдалася, спроб доставки більше не буде.
     *
     * __spam__ — повідомлення доставлено, але позначено як “спам” отримувачем.
     * Значення: константи `EmailStatus`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Внутрішній детальний статус доставки AllyMailer. Можна вказати декілька статусів через кому. Ось деякі з
     * можливих статусів:
     *
     * __err_user_unknown__ -- адреса не існує (і невідомо, чи існувала колись);
     *
     * __err_user_inactive__ -- адреса не використовується;
     *
     * __err_will_retry__ -- лист було тимчасово відхилено, пізніше буде здійснено повторну спробу доставки;
     *
     * __err_mailbox_discarded__ -- адресу видалено (тобто колись існувала, але тепер її немає);
     *
     * __err_mailbox_full__ -- поштова скринька переповнена;
     *
     * __err_spam_rejected__ -- лист відхилено як спам;
     *
     * __err_blacklisted__ -- лист було відхилено через наявність IP-адреси або домену відправника в якомусь із
     * чорних списків;
     *
     * __err_too_large__ -- на думку сервера отримувача, лист перевищує допустимий розмір;
     *
     * __err_unsubscribed__ -- адресат раніше відписався від ваших розсилок;
     *
     * __err_unreachable__ -- адресу позначено як постійно недоступну через багаторазові помилки доставки на цю
     * адресу;
     *
     * __err_skip_letter__ -- надсилання скасовано, оскільки email-адреса тимчасово недоступна;
     *
     * __err_domain_inactive__ -- домен не приймає пошту або не існує;
     *
     * __err_destination_misconfigured__ -- домен не приймає пошту через неправильне налаштування на боці отримувача,
     * причому відповідь сервера містить інформацію про усувну причину (наприклад, використовується непрацюючий
     * блеклист тощо);
     *
     * __err_delivery_failed__ -- доставка не вдалася з інших причин;
     *
     * __err_spam_skipped__ -- надсилання скасовано через блокування розсилки як спаму;
     *
     * __err_lost__ -- лист не було надіслано через неузгодженість його частин, або його було втрачено через збій на
     * нашому боці. Відправник має повторно надіслати лист самостійно, оскільки оригінал не зберігся;
     *
     * Ми залишаємо за собою право змінювати й додавати внутрішні статуси, тому решту
     * використовуваних наразі статусів перелічимо лише довідково, без пояснень:
     * ok_accepted, ok_sent, ok_delivered, ok_read, ok_link_visited, ok_unsubscribed, ok_resubscribed,
     * ok_spam_folder, ok_fbl,
     * not_sent, skip_dup_unreachable, skip_dup_temp_unreachable, skip_dup_mailbox_full,
     * err_spam_removed, err_resend, err_unknown, err_retry_letter, err_src_invalid,
     * err_dest_invalid, err_not_available, err_internal, err_no_dns, err_no_smtp, err_giveup.
     *
     * @var string|null
     */
    private $deliveryStatus;

    /**
     * Адреса отримувача
     * Приклад: `david@example.org`.
     *
     * @var string|null
     */
    private $email;

    /**
     * Адреса відправника
     * Приклад: `sender@example.com`.
     *
     * @var string|null
     */
    private $emailFrom;

    /**
     * Домен отримувача
     * Приклад: `example.org`.
     *
     * @var string|null
     */
    private $domain;

    /**
     * Ідентифікатор розсилки, невід'ємне десяткове ціле або UUID до 128 біт, передане в метаданих у полі з іменем
     * "campaign_id" (ім'я можна налаштувати через техпідтримку).
     * Приклад: `c77f4f4e-3561-49f7-9f07-c35be01b4f43`.
     *
     * @var string|null
     */
    private $campaignId;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->jobId = Data::string($data['job_id'] ?? null);
        $model->status = Data::string($data['status'] ?? null);
        $model->deliveryStatus = Data::string($data['delivery_status'] ?? null);
        $model->email = Data::string($data['email'] ?? null);
        $model->emailFrom = Data::string($data['email_from'] ?? null);
        $model->domain = Data::string($data['domain'] ?? null);
        $model->campaignId = Data::string($data['campaign_id'] ?? null);

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
     * Статус email.
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Статус email.
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
     * Внутрішній детальний статус доставки AllyMailer.
     */
    public function getDeliveryStatus(): ?string
    {
        return $this->deliveryStatus;
    }

    /**
     * Внутрішній детальний статус доставки AllyMailer.
     *
     * @return $this
     */
    public function setDeliveryStatus(?string $deliveryStatus): self
    {
        $this->deliveryStatus = $deliveryStatus;

        return $this;
    }

    /**
     * Адреса отримувача
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Адреса отримувача
     *
     * @return $this
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Адреса відправника
     */
    public function getEmailFrom(): ?string
    {
        return $this->emailFrom;
    }

    /**
     * Адреса відправника
     *
     * @return $this
     */
    public function setEmailFrom(?string $emailFrom): self
    {
        $this->emailFrom = $emailFrom;

        return $this;
    }

    /**
     * Домен отримувача
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * Домен отримувача
     *
     * @return $this
     */
    public function setDomain(?string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Ідентифікатор розсилки, невід'ємне десяткове ціле або UUID до 128 біт, передане в метаданих у полі з іменем
     * "campaign_id" (ім'я можна налаштувати через техпідтримку).
     */
    public function getCampaignId(): ?string
    {
        return $this->campaignId;
    }

    /**
     * Ідентифікатор розсилки, невід'ємне десяткове ціле або UUID до 128 біт, передане в метаданих у полі з іменем
     * "campaign_id" (ім'я можна налаштувати через техпідтримку).
     *
     * @return $this
     */
    public function setCampaignId(?string $campaignId): self
    {
        $this->campaignId = $campaignId;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'job_id' => $this->jobId,
            'status' => $this->status,
            'delivery_status' => $this->deliveryStatus,
            'email' => $this->email,
            'email_from' => $this->emailFrom,
            'domain' => $this->domain,
            'campaign_id' => $this->campaignId,
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
