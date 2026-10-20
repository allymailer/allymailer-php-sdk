<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

/**
 * EmailStatus
 */
final class EmailStatus
{
    public const SENT = 'sent';
    public const DELIVERED = 'delivered';
    public const OPENED = 'opened';
    public const CLICKED = 'clicked';
    public const UNSUBSCRIBED = 'unsubscribed';
    public const SUBSCRIBED = 'subscribed';
    public const SOFT_BOUNCED = 'soft_bounced';
    public const HARD_BOUNCED = 'hard_bounced';
    public const SPAM = 'spam';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::SENT,
            self::DELIVERED,
            self::OPENED,
            self::CLICKED,
            self::UNSUBSCRIBED,
            self::SUBSCRIBED,
            self::SOFT_BOUNCED,
            self::HARD_BOUNCED,
            self::SPAM,
        ];
    }

    private function __construct()
    {
    }
}
