<?php

declare(strict_types=1);

namespace AllyMailer\Api\Template\Model;

/**
 * Тип редактора шаблону у вебінтерфейсі, "html" або "visual". За замовчуванням — "html". Створення шаблонів із
 * типом редактора "visual" можливе лише через вебінтерфейс.
 */
final class EditorType
{
    public const HTML = 'html';
    public const VISUAL = 'visual';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::HTML,
            self::VISUAL,
        ];
    }

    private function __construct()
    {
    }
}
