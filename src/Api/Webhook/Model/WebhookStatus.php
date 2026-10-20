<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Статус webhook, за замовчуванням "active". Статус "disabled" означає, що webhook було вимкнено користувачем,
 * "stopped" означає, що webhook було зупинено системою після 24 годин невдалих викликів (мінімум за 10 різними
 * подіями).
 */
final class WebhookStatus
{
    public const ACTIVE = 'active';
    public const DISABLED = 'disabled';
    public const STOPPED = 'stopped';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::ACTIVE,
            self::DISABLED,
            self::STOPPED,
        ];
    }

    private function __construct()
    {
    }
}
