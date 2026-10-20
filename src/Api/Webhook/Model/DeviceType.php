<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Тип пристрою отримувача, визначений за user agent. Присутній для статусів "clicked" і "opened"; дорівнює
 * "unknown", якщо тип пристрою визначити не вдалося.
 */
enum DeviceType: string
{
    case Desktop = 'desktop';
    case Mobile = 'mobile';
    case Tablet = 'tablet';
    case Other = 'other';
    case Unknown = 'unknown';
}
