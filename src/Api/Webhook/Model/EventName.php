<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Тип даних, що містяться в об'єкті event_data. Або "transactional_email_status", або
 * "transactional_spam_block".
 */
final class EventName
{
    public const TRANSACTIONAL_EMAIL_STATUS = 'transactional_email_status';
    public const TRANSACTIONAL_SPAM_BLOCK = 'transactional_spam_block';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::TRANSACTIONAL_EMAIL_STATUS,
            self::TRANSACTIONAL_SPAM_BLOCK,
        ];
    }

    private function __construct()
    {
    }
}
