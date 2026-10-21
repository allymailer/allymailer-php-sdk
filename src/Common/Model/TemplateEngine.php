<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

/**
 * Параметр для вибору [шаблонізатора](https://docs.allymailer.com.ua/ua/template-engines) — або "simple", або
 * "velocity", або "liquid", або "none". За замовчуванням — "simple".
 */
final class TemplateEngine
{
    public const SIMPLE = 'simple';
    public const VELOCITY = 'velocity';
    public const LIQUID = 'liquid';
    public const NONE = 'none';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::SIMPLE,
            self::VELOCITY,
            self::LIQUID,
            self::NONE,
        ];
    }

    private function __construct()
    {
    }
}
