<?php

declare(strict_types=1);

namespace AllyMailer\Client\Transport;

use AllyMailer\Client\ApiException;

/**
 * Sends one HTTP POST request. The default implementation is CurlTransport, Psr18Transport adapts any PSR-18 client.
 */
interface TransportInterface
{
    /**
     * @param array<string, string> $headers
     *
     * @return array{status: int, body: string}
     *
     * @throws ApiException when the request can not be sent
     */
    public function post(string $url, array $headers, string $body, float $timeout): array;
}
