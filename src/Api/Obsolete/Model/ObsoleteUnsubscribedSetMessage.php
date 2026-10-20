<?php

declare(strict_types=1);

namespace AllyMailer\Api\Obsolete\Model;

/**
 * Подробиці відписки:
 *
 * - "unsubscribed" якщо email було щойно відписано,
 * - "was inactive" якщо він уже був позначений як неактивний і немає сенсу відписувати,
 * - "was unsubscribed" якщо email уже було відписано раніше,
 * - "added and unsubscribed" якщо для цього email не зберігалося жодного більш раннього статусу, тому його було додано й одразу ж відписано.
 */
final class ObsoleteUnsubscribedSetMessage
{
    public const UNSUBSCRIBED = 'unsubscribed';
    public const WAS_INACTIVE = 'was inactive';
    public const WAS_UNSUBSCRIBED = 'was unsubscribed';
    public const ADDED_AND_UNSUBSCRIBED = 'added and unsubscribed';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::UNSUBSCRIBED,
            self::WAS_INACTIVE,
            self::WAS_UNSUBSCRIBED,
            self::ADDED_AND_UNSUBSCRIBED,
        ];
    }

    private function __construct()
    {
    }
}
