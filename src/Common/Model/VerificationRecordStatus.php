<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

/**
 * Лише домени зі статусом "confirmed" запису про володіння доменом можуть використовуватися для надсилання
 * листів.
 */
enum VerificationRecordStatus: string
{
    case Confirmed = 'confirmed';
    case Unconfirmed = 'unconfirmed';
}
