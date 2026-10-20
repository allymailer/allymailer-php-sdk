<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

/**
 * Встановлює режим роботи лічильника листів. Дозволяє вибрати, як має поводитися лічильник: автоматично
 * скидатися чи залишатися постійним. Припустимі значення: default - лічильник автоматично скидається в нуль на
 * початку кожного облікового періоду, permanent - лічильник ніколи не скидається автоматично. Скидання може бути
 * виконане лише вручну користувачем, передавши значення 0 у полі 'email_counter'. Якщо поле не передано в запиті
 * або передано значення null, значення режиму не змінюється.
 */
final class EmailCounterMode
{
    public const DEFAULT = 'default';
    public const PERMANENT = 'permanent';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::DEFAULT,
            self::PERMANENT,
        ];
    }

    private function __construct()
    {
    }
}
