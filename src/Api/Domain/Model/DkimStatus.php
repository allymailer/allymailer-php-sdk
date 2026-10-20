<?php

declare(strict_types=1);

namespace AllyMailer\Api\Domain\Model;

/**
 * Лише домени зі статусом DKIM-запису "active" можуть використовуватися для надсилання листів.
 */
final class DkimStatus
{
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE,
        ];
    }

    private function __construct()
    {
    }
}
