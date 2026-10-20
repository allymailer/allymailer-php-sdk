<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Якість трафіку для статусів "opened" і "clicked". "human" — розпізнано звичайний браузер або поштовий клієнт
 * без машинних ознак; "machine" — бот, сканер посилань або проксі безпеки; "protected" — механізм приватності
 * скриньки/ОС, участь людини підтвердити не можна (Apple Mail Privacy Protection / iCloud Private Relay, Gmail
 * Image Proxy; Apple MPP — це protected, не machine); "unknown" — User-Agent відсутній, пошкоджений або не
 * розпізнаний.
 */
final class TrafficType
{
    public const HUMAN = 'human';
    public const MACHINE = 'machine';
    public const PROTECTED = 'protected';
    public const UNKNOWN = 'unknown';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::HUMAN,
            self::MACHINE,
            self::PROTECTED,
            self::UNKNOWN,
        ];
    }

    private function __construct()
    {
    }
}
