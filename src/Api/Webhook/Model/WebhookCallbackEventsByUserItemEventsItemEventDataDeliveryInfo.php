<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт з додатковою інформацією про доставку. Присутній лише якщо властивість delivery_info під час
 * встановлення webhook дорівнювала 1 і якщо event_name="transactional_email_status".
 */
final class WebhookCallbackEventsByUserItemEventsItemEventDataDeliveryInfo implements \JsonSerializable
{
    /**
     * Внутрішній детальний статус доставки AllyMailer. Ось деякі з можливих статусів:
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
     * Відповідь SMTP-сервера.
     *
     * @var string|null
     */
    private $destinationResponse;

    /**
     * Рядок user agent отримувача. Присутній лише якщо вдалося його визначити, для статусів "clicked" і "opened".
     * Приклад: `Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133
     * Safari/537.36`.
     *
     * @var string|null
     */
    private $userAgent;

    /**
     * Тип пристрою отримувача, визначений за user agent. Присутній для статусів "clicked" і "opened"; дорівнює
     * "unknown", якщо тип пристрою визначити не вдалося.
     * Значення: константи `DeviceType`.
     *
     * @var string|null
     */
    private $deviceType;

    /**
     * Марка пристрою отримувача, визначена за user agent. Присутня для статусів "clicked" і "opened", якщо її
     * вдалося визначити. Для device_type "mobile" і "tablet" присутня завжди та дорівнює "unknown", якщо марку
     * визначити не вдалося.
     * Приклад: `Apple`.
     *
     * @var string|null
     */
    private $deviceBrand;

    /**
     * Назва операційної системи пристрою отримувача, визначена за user agent. Присутня для статусів "clicked" і
     * "opened"; дорівнює "unknown", якщо ОС визначити не вдалося.
     * Приклад: `GNU/Linux`.
     *
     * @var string|null
     */
    private $osName;

    /**
     * Назва браузера, у якому було відкрито лист, визначена за user agent. Присутня для статусів "clicked" і
     * "opened", лише якщо було визначено браузер, тому ніколи не надходить разом з email_client_name.
     * Приклад: `Chrome`.
     *
     * @var string|null
     */
    private $browserName;

    /**
     * Назва поштового клієнта, у якому було відкрито лист, визначена за user agent. Присутня для статусів "clicked"
     * і "opened", лише якщо було визначено поштовий клієнт, тому ніколи не надходить разом з browser_name.
     * Приклад: `Microsoft Outlook`.
     *
     * @var string|null
     */
    private $emailClientName;

    /**
     * Якість трафіку для статусів "opened" і "clicked". "human" — розпізнано звичайний браузер або поштовий клієнт
     * без машинних ознак; "machine" — бот, сканер посилань або проксі безпеки; "protected" — механізм приватності
     * скриньки/ОС, участь людини підтвердити не можна (Apple Mail Privacy Protection / iCloud Private Relay, Gmail
     * Image Proxy; Apple MPP — це protected, не machine); "unknown" — User-Agent відсутній, пошкоджений або не
     * розпізнаний.
     * Значення: константи `TrafficType`.
     *
     * @var string|null
     */
    private $trafficType;

    /**
     * IP-адреса отримувача. Присутня лише якщо вдалося її визначити, для статусів "clicked" і "opened".
     * Приклад: `111.222.33.44`.
     *
     * @var string|null
     */
    private $ip;

    /**
     * ISO 3166-1 alpha-2 код країни, визначений за IP-адресою отримувача. Присутній для статусів "clicked" і
     * "opened".
     * Приклад: `DE`.
     *
     * @var string|null
     */
    private $countryCode;

    /**
     * Країна, визначена за IP-адресою отримувача. Присутня для статусів "clicked" і "opened".
     * Приклад: `Germany`.
     *
     * @var string|null
     */
    private $country;

    /**
     * Місто, визначене за IP-адресою отримувача. Присутнє для статусів "clicked" і "opened".
     * Приклад: `Berlin`.
     *
     * @var string|null
     */
    private $city;

    /**
     * IP-адреса SMTP-сервера, з якого було надіслано лист. Присутня лише для статусів "delivered", "soft_bounced" і
     * "hard_bounced", якщо доступна.
     * Приклад: `192.0.2.10`.
     *
     * @var string|null
     */
    private $senderIp;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->deliveryStatus = Data::string($data['delivery_status'] ?? null);
        $model->destinationResponse = Data::string($data['destination_response'] ?? null);
        $model->userAgent = Data::string($data['user_agent'] ?? null);
        $model->deviceType = Data::string($data['device_type'] ?? null);
        $model->deviceBrand = Data::string($data['device_brand'] ?? null);
        $model->osName = Data::string($data['os_name'] ?? null);
        $model->browserName = Data::string($data['browser_name'] ?? null);
        $model->emailClientName = Data::string($data['email_client_name'] ?? null);
        $model->trafficType = Data::string($data['traffic_type'] ?? null);
        $model->ip = Data::string($data['ip'] ?? null);
        $model->countryCode = Data::string($data['country_code'] ?? null);
        $model->country = Data::string($data['country'] ?? null);
        $model->city = Data::string($data['city'] ?? null);
        $model->senderIp = Data::string($data['sender_ip'] ?? null);

        return $model;
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
     * Відповідь SMTP-сервера.
     */
    public function getDestinationResponse(): ?string
    {
        return $this->destinationResponse;
    }

    /**
     * Відповідь SMTP-сервера.
     *
     * @return $this
     */
    public function setDestinationResponse(?string $destinationResponse): self
    {
        $this->destinationResponse = $destinationResponse;

        return $this;
    }

    /**
     * Рядок user agent отримувача.
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    /**
     * Рядок user agent отримувача.
     *
     * @return $this
     */
    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Тип пристрою отримувача, визначений за user agent.
     *
     * @return string|null
     */
    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    /**
     * Тип пристрою отримувача, визначений за user agent.
     *
     * @param string|null $deviceType Значення: константи `DeviceType`.
     *
     * @return $this
     */
    public function setDeviceType(?string $deviceType): self
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    /**
     * Марка пристрою отримувача, визначена за user agent.
     */
    public function getDeviceBrand(): ?string
    {
        return $this->deviceBrand;
    }

    /**
     * Марка пристрою отримувача, визначена за user agent.
     *
     * @return $this
     */
    public function setDeviceBrand(?string $deviceBrand): self
    {
        $this->deviceBrand = $deviceBrand;

        return $this;
    }

    /**
     * Назва операційної системи пристрою отримувача, визначена за user agent.
     */
    public function getOsName(): ?string
    {
        return $this->osName;
    }

    /**
     * Назва операційної системи пристрою отримувача, визначена за user agent.
     *
     * @return $this
     */
    public function setOsName(?string $osName): self
    {
        $this->osName = $osName;

        return $this;
    }

    /**
     * Назва браузера, у якому було відкрито лист, визначена за user agent.
     */
    public function getBrowserName(): ?string
    {
        return $this->browserName;
    }

    /**
     * Назва браузера, у якому було відкрито лист, визначена за user agent.
     *
     * @return $this
     */
    public function setBrowserName(?string $browserName): self
    {
        $this->browserName = $browserName;

        return $this;
    }

    /**
     * Назва поштового клієнта, у якому було відкрито лист, визначена за user agent.
     */
    public function getEmailClientName(): ?string
    {
        return $this->emailClientName;
    }

    /**
     * Назва поштового клієнта, у якому було відкрито лист, визначена за user agent.
     *
     * @return $this
     */
    public function setEmailClientName(?string $emailClientName): self
    {
        $this->emailClientName = $emailClientName;

        return $this;
    }

    /**
     * Якість трафіку для статусів "opened" і "clicked". "human" — розпізнано звичайний браузер або поштовий клієнт
     * без машинних ознак; "machine" — бот, сканер посилань або проксі безпеки; "protected" — механізм приватності
     * скриньки/ОС, участь людини підтвердити не можна (Apple Mail Privacy Protection / iCloud Private Relay, Gmail
     * Image Proxy; Apple MPP — це protected, не machine); "unknown" — User-Agent відсутній, пошкоджений або не
     * розпізнаний.
     *
     * @return string|null
     */
    public function getTrafficType(): ?string
    {
        return $this->trafficType;
    }

    /**
     * Якість трафіку для статусів "opened" і "clicked". "human" — розпізнано звичайний браузер або поштовий клієнт
     * без машинних ознак; "machine" — бот, сканер посилань або проксі безпеки; "protected" — механізм приватності
     * скриньки/ОС, участь людини підтвердити не можна (Apple Mail Privacy Protection / iCloud Private Relay, Gmail
     * Image Proxy; Apple MPP — це protected, не machine); "unknown" — User-Agent відсутній, пошкоджений або не
     * розпізнаний.
     *
     * @param string|null $trafficType Значення: константи `TrafficType`.
     *
     * @return $this
     */
    public function setTrafficType(?string $trafficType): self
    {
        $this->trafficType = $trafficType;

        return $this;
    }

    /**
     * IP-адреса отримувача.
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * IP-адреса отримувача.
     *
     * @return $this
     */
    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * ISO 3166-1 alpha-2 код країни, визначений за IP-адресою отримувача.
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * ISO 3166-1 alpha-2 код країни, визначений за IP-адресою отримувача.
     *
     * @return $this
     */
    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Країна, визначена за IP-адресою отримувача.
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Країна, визначена за IP-адресою отримувача.
     *
     * @return $this
     */
    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Місто, визначене за IP-адресою отримувача.
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Місто, визначене за IP-адресою отримувача.
     *
     * @return $this
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * IP-адреса SMTP-сервера, з якого було надіслано лист.
     */
    public function getSenderIp(): ?string
    {
        return $this->senderIp;
    }

    /**
     * IP-адреса SMTP-сервера, з якого було надіслано лист.
     *
     * @return $this
     */
    public function setSenderIp(?string $senderIp): self
    {
        $this->senderIp = $senderIp;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'delivery_status' => $this->deliveryStatus,
            'destination_response' => $this->destinationResponse,
            'user_agent' => $this->userAgent,
            'device_type' => $this->deviceType,
            'device_brand' => $this->deviceBrand,
            'os_name' => $this->osName,
            'browser_name' => $this->browserName,
            'email_client_name' => $this->emailClientName,
            'traffic_type' => $this->trafficType,
            'ip' => $this->ip,
            'country_code' => $this->countryCode,
            'country' => $this->country,
            'city' => $this->city,
            'sender_ip' => $this->senderIp,
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
