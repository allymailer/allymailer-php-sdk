<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Тип даних, що містяться в об'єкті event_data. Або "transactional_email_status", або
 * "transactional_spam_block".
 */
enum EventName: string
{
    case TransactionalEmailStatus = 'transactional_email_status';
    case TransactionalSpamBlock = 'transactional_spam_block';
}
