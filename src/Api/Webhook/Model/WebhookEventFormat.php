<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Формат сповіщень. "json_post"(за замовчуванням) або "json_post_gzip".
 */
final class WebhookEventFormat
{
    public const JSON_POST = 'json_post';
    public const JSON_POST_GZIP = 'json_post_gzip';

    /**
     * @return list<string> Every value.
     */
    public static function values(): array
    {
        return [
            self::JSON_POST,
            self::JSON_POST_GZIP,
        ];
    }

    private function __construct()
    {
    }
}
