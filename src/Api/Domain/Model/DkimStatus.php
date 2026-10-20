<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

/**
 * Лише домени зі статусом DKIM-запису "active" можуть використовуватися для надсилання листів.
 */
enum DkimStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
}
