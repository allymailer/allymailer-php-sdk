<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Це подія блокування чи розблокування. Властивість присутня лише якщо event_name="transactional_spam_block".
 */
enum DomainStatus: string
{
    case Blocked = 'blocked';
    case Unblocked = 'unblocked';
}
