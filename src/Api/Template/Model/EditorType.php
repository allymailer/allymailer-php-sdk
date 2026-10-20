<?php

declare(strict_types=1);

namespace AllyMailer\Api\Template\Model;

/**
 * Тип редактора шаблону у вебінтерфейсі, "html" або "visual". За замовчуванням — "html". Створення шаблонів із
 * типом редактора "visual" можливе лише через вебінтерфейс.
 */
enum EditorType: string
{
    case Html = 'html';
    case Visual = 'visual';
}
