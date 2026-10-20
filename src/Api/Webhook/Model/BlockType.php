<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Тип спам-блока — заблоковано або один відправляючий SMTP, або одразу багато. У разі блокування одиночного SMTP
 * із загального пулу AllyMailer пробуватиме ще декілька. Властивість присутня лише якщо
 * event_name="transactional_spam_block".
 */
enum BlockType: string
{
    case OneSmtp = 'one_smtp';
    case AllSmtp = 'all_smtp';
}
