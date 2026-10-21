<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

/**
 * Параметр для вибору [шаблонізатора](https://docs.allymailer.com.ua/ua/template-engines) — або "simple", або
 * "velocity", або "liquid", або "none". За замовчуванням — "simple".
 */
enum TemplateEngine: string
{
    case Simple = 'simple';
    case Velocity = 'velocity';
    case Liquid = 'liquid';
    case None = 'none';
}
