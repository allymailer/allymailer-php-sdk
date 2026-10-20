<?php

declare(strict_types=1);

namespace AllyMailer\Api\Webhook\Model;

/**
 * Формат сповіщень. "json_post"(за замовчуванням) або "json_post_gzip".
 */
enum WebhookEventFormat: string
{
    case JsonPost = 'json_post';
    case JsonPostGzip = 'json_post_gzip';
}
