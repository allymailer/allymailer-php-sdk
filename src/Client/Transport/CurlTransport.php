<?php

declare(strict_types=1);

namespace AllyMailer\Client\Transport;

use AllyMailer\Client\ApiException;

/**
 * Default transport on ext-curl: no HTTP client library is needed.
 */
final class CurlTransport implements TransportInterface
{
    public function post(string $url, array $headers, string $body, float $timeout): array
    {
        $handle = \curl_init($url);
        if (false === $handle) {
            throw new ApiException('HTTP request failed: can not initialize cURL');
        }

        $headerLines = [];
        foreach ($headers as $name => $value) {
            $headerLines[] = $name . ': ' . $value;
        }

        \curl_setopt_array($handle, [
            \CURLOPT_POST => true,
            \CURLOPT_POSTFIELDS => $body,
            \CURLOPT_HTTPHEADER => $headerLines,
            \CURLOPT_RETURNTRANSFER => true,
            \CURLOPT_TIMEOUT_MS => (int)($timeout * 1000),
        ]);

        $response = \curl_exec($handle);
        if (!\is_string($response)) {
            throw new ApiException('HTTP request failed: ' . \curl_error($handle));
        }

        return [
            'status' => (int)\curl_getinfo($handle, \CURLINFO_RESPONSE_CODE),
            'body' => $response,
        ];
    }
}
