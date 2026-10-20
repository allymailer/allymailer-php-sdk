<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

/**
 * Лише домени зі статусом "confirmed" запису про володіння доменом можуть використовуватися для надсилання
 * листів.
 */
final class VerificationRecordStatus
{
    public const CONFIRMED = 'confirmed';
    public const UNCONFIRMED = 'unconfirmed';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::CONFIRMED,
            self::UNCONFIRMED,
        ];
    }

    private function __construct()
    {
    }
}
