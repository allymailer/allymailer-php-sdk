<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Тип спам-блока — заблоковано або один відправляючий SMTP, або одразу багато. У разі блокування одиночного SMTP
 * із загального пулу AllyMailer пробуватиме ще декілька. Властивість присутня лише якщо
 * event_name="transactional_spam_block".
 */
final class BlockType
{
    public const ONE_SMTP = 'one_smtp';
    public const ALL_SMTP = 'all_smtp';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::ONE_SMTP,
            self::ALL_SMTP,
        ];
    }

    private function __construct()
    {
    }
}
