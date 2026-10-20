<?php

declare(strict_types=1);

namespace AllyMailer;

use AllyMailer\Client\Configuration;
use AllyMailer\Client\Transport\TransportInterface;

/**
 * Shortcut to create the AllyMailer API client.
 *
 * ```php
 * $client = AllyMailer::client('YOUR_API_KEY');
 * ```
 */
final class AllyMailer
{
    /**
     * @param string $apiKey User or project API key.
     * @param string|null $host API host (Configuration::HOST_* constant, e.g. 'cp.allymailer.com') or a full base URL, null: Configuration::DEFAULT_BASE_URL.
     * @param TransportInterface|null $transport HTTP transport, null: cURL (Psr18Transport for PSR-18 clients).
     */
    public static function client(
        string $apiKey,
        ?string $host = null,
        ?TransportInterface $transport = null,
        float $timeout = 30.0,
    ): AllyMailerClient {
        return new AllyMailerClient(
            new Configuration($apiKey, null === $host ? Configuration::DEFAULT_BASE_URL : Configuration::baseUrlFor($host), $timeout),
            $transport,
        );
    }
}
