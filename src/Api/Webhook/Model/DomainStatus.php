<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Це подія блокування чи розблокування. Властивість присутня лише якщо event_name="transactional_spam_block".
 */
final class DomainStatus
{
    public const BLOCKED = 'blocked';
    public const UNBLOCKED = 'unblocked';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::BLOCKED,
            self::UNBLOCKED,
        ];
    }

    private function __construct()
    {
    }
}
