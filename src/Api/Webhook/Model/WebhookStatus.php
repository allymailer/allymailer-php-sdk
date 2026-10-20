<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Статус webhook, за замовчуванням "active". Статус "disabled" означає, що webhook було вимкнено користувачем,
 * "stopped" означає, що webhook було зупинено системою після 24 годин невдалих викликів (мінімум за 10 різними
 * подіями).
 */
enum WebhookStatus: string
{
    case Active = 'active';
    case Disabled = 'disabled';
    case Stopped = 'stopped';
}
