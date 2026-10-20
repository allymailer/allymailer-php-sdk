<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Тип пристрою отримувача, визначений за user agent. Присутній для статусів "clicked" і "opened"; дорівнює
 * "unknown", якщо тип пристрою визначити не вдалося.
 */
final class DeviceType
{
    public const DESKTOP = 'desktop';
    public const MOBILE = 'mobile';
    public const TABLET = 'tablet';
    public const OTHER = 'other';
    public const UNKNOWN = 'unknown';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::DESKTOP,
            self::MOBILE,
            self::TABLET,
            self::OTHER,
            self::UNKNOWN,
        ];
    }

    private function __construct()
    {
    }
}
