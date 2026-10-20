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
enum ObsoleteUnsubscribedSetMessage: string
{
    case Unsubscribed = 'unsubscribed';
    case WasInactive = 'was inactive';
    case WasUnsubscribed = 'was unsubscribed';
    case AddedAndUnsubscribed = 'added and unsubscribed';
}
