<?php

declare(strict_types=1);

namespace AllyMailer;

use AllyMailer\Api\ConfirmedEmail\ConfirmedEmailApi;
use AllyMailer\Api\Domain\DomainApi;
use AllyMailer\Api\EmailValidation\EmailValidationApi;
use AllyMailer\Api\Email\EmailApi;
use AllyMailer\Api\EventDump\EventDumpApi;
use AllyMailer\Api\Obsolete\ObsoleteApi;
use AllyMailer\Api\Project\ProjectApi;
use AllyMailer\Api\Suppression\SuppressionApi;
use AllyMailer\Api\System\SystemApi;
use AllyMailer\Api\Tag\TagApi;
use AllyMailer\Api\Template\TemplateApi;
use AllyMailer\Api\Webhook\WebhookApi;
use AllyMailer\Client\ApiClient;
use AllyMailer\Client\Configuration;
use AllyMailer\Client\Transport\TransportInterface;

/**
 * Entry point of the AllyMailer API client: one accessor per section.
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 * ```
 */
final class AllyMailerClient
{
    /** @var ApiClient */
    private $client;

    /** @var EmailApi|null */
    private $email;

    /** @var EmailValidationApi|null */
    private $emailValidation;

    /** @var ConfirmedEmailApi|null */
    private $confirmedEmail;

    /** @var TemplateApi|null */
    private $template;

    /** @var WebhookApi|null */
    private $webhook;

    /** @var SuppressionApi|null */
    private $suppression;

    /** @var DomainApi|null */
    private $domain;

    /** @var EventDumpApi|null */
    private $eventDump;

    /** @var TagApi|null */
    private $tag;

    /** @var ProjectApi|null */
    private $project;

    /** @var SystemApi|null */
    private $system;

    /** @var ObsoleteApi|null */
    private $obsolete;

    /**
     * @param TransportInterface|null $transport null: the default cURL transport
     */
    public function __construct(Configuration $config, ?TransportInterface $transport = null)
    {
        $this->client = new ApiClient($config, $transport);
    }

    /**
     * Ця група методів пов'язана з надсиланням email.
     */
    public function email(): EmailApi
    {
        if (null === $this->email) {
            $this->email = new EmailApi($this->client);
        }

        return $this->email;
    }

    /**
     * Методи перевірки email-адрес. Перевірка адреси електронної пошти надає докладну інформацію про працездатність
     * email. Це дозволить виключити з надсилання неіснуючі email, знизити показник скарг, очистити список
     * підписників і врешті-решт покращити вашу репутацію як відправника. Наприклад, ви можете інтегрувати процес
     * перевірки у форму реєстрації вашого сайту і вже на етапі введення адреси повідомляти користувачам, що адреса,
     * яку вони ввели у форму, недійсна.
     */
    public function emailValidation(): EmailValidationApi
    {
        if (null === $this->emailValidation) {
            $this->emailValidation = new EmailValidationApi($this->client);
        }

        return $this->emailValidation;
    }

    /**
     * Керування email-адресами, підтвердженими для надсилання із sandbox-домену. Методи доступні лише з API-ключем
     * основного облікового запису.
     */
    public function confirmedEmail(): ConfirmedEmailApi
    {
        if (null === $this->confirmedEmail) {
            $this->confirmedEmail = new ConfirmedEmailApi($this->client);
        }

        return $this->confirmedEmail;
    }

    /**
     * Ви можете зберегти шаблон на боці AllyMailer і потім посилатися на нього за ідентифікатором. Це не
     * обов'язково, але вкрай рекомендовано у разі повторюваних email-повідомлень або за великих обсягів надсилання.
     * AllyMailer підтримує два різні синтаксиси для шаблонів, докладніше читайте
     * [тут](https://docs.allymailer.com.ua/ua/template-engines).
     */
    public function template(): TemplateApi
    {
        if (null === $this->template) {
            $this->template = new TemplateApi($this->client);
        }

        return $this->template;
    }

    /**
     * AllyMailer дозволяє вам отримувати сповіщення про зміну статусу доставки листа або спам-блокування. Ви надаєте
     * URL, і в разі виникнення події, що вас цікавить, ми сповіщаємо вас, передаючи на цей URL JSON-дані про подію.
     */
    public function webhook(): WebhookApi
    {
        if (null === $this->webhook) {
            $this->webhook = new WebhookApi($this->client);
        }

        return $this->webhook;
    }

    /**
     * Методи для керування адресами, надсилання на які заблоковано з різних причин — відписка, недоступність,
     * скарги.
     */
    public function suppression(): SuppressionApi
    {
        if (null === $this->suppression) {
            $this->suppression = new SuppressionApi($this->client);
        }

        return $this->suppression;
    }

    /**
     * Методи для налаштування доменів надсилання та перевірки їх статусів. Корисні, якщо вам недостатньо додавання
     * доменів через вебінтерфейс AllyMailer і, наприклад, хочеться автоматизувати додавання доменів для ваших
     * власних клієнтів.
     */
    public function domain(): DomainApi
    {
        if (null === $this->domain) {
            $this->domain = new DomainApi($this->client);
        }

        return $this->domain;
    }

    /**
     * Методи для отримання списку подій, що сталися, за певний період. Дані зберігаються до 45 днів, залежно від
     * вашого тарифу. Це означає, що можна запросити події, починаючи з 00:00:00 45-го дня тому і до поточного
     * моменту часу. Для індивідуальних тарифів з великими обсягами за замовчуванням події доступні лише за останні 7
     * днів.
     */
    public function eventDump(): EventDumpApi
    {
        if (null === $this->eventDump) {
            $this->eventDump = new EventDumpApi($this->client);
        }

        return $this->eventDump;
    }

    /**
     * Методи керування користувацькими мітками. За допомогою міток ви можете класифікувати листи за потрібними
     * критеріями. Відокремити маркетингові листи від транзакційних або листи з підтвердженням реєстрації від
     * сповіщень про замовлення. AllyMailer дозволяє позначати мітками кожне вихідне повідомлення, а потім
     * сегментувати й аналізувати статистику на основі зазначених під час надсилання міток.
     */
    public function tag(): TagApi
    {
        if (null === $this->tag) {
            $this->tag = new TagApi($this->client);
        }

        return $this->tag;
    }

    /**
     * Проєкти дозволяють об'єднати кілька незалежних доменів із webhook, шаблонами та списками відписки. Це дуже
     * корисно, якщо у вас є власні клієнти і ви керуєте їхніми даними з одного облікового запису AllyMailer. Кожен
     * проєкт отримує власний ключ API, а виклики методів API з цим ключем обробляють лише дані цього проєкту. Таким
     * чином, ви можете призначити окремий проєкт для кожного користувача і бути впевненими, що вони не
     * конфліктуватимуть: наприклад, відписка від одного проєкту не вплине на інший.
     */
    public function project(): ProjectApi
    {
        if (null === $this->project) {
            $this->project = new ProjectApi($this->client);
        }

        return $this->project;
    }

    /**
     * Системні методи.
     */
    public function system(): SystemApi
    {
        if (null === $this->system) {
            $this->system = new SystemApi($this->client);
        }

        return $this->system;
    }

    /**
     * Застарілі методи роботи з відписками. Ми рекомендуємо користуватися замість них гнучкішими методами
     * [suppression](#suppression). Зверніть увагу, що знову підписати відписаного адресата через WebAPI не можна.
     * Можна лише надіслати йому email із посиланням повторної підписки за допомогою методу email/subscribe.
     */
    public function obsolete(): ObsoleteApi
    {
        if (null === $this->obsolete) {
            $this->obsolete = new ObsoleteApi($this->client);
        }

        return $this->obsolete;
    }
}
