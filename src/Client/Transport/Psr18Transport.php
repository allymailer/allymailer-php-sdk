<?php

declare(strict_types=1);

namespace AllyMailer\Client\Transport;

use AllyMailer\Client\ApiException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Sends the requests with any PSR-18 HTTP client (Guzzle, Symfony HttpClient, ...):
 *
 * ```php
 * $factory = new GuzzleHttp\Psr7\HttpFactory();
 * $client = AllyMailer::client('YOUR_API_KEY', null, new Psr18Transport(new GuzzleHttp\Client(), $factory, $factory));
 * ```
 */
final class Psr18Transport implements TransportInterface
{
    /** @var ClientInterface */
    private $httpClient;

    /** @var RequestFactoryInterface */
    private $requestFactory;

    /** @var StreamFactoryInterface */
    private $streamFactory;

    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function post(string $url, array $headers, string $body, float $timeout): array
    {
        $request = $this->requestFactory->createRequest('POST', $url)
            ->withBody($this->streamFactory->createStream($body));
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new ApiException('HTTP request failed: ' . $e->getMessage(), 0, null, null, $e);
        }

        return [
            'status' => $response->getStatusCode(),
            'body' => (string)$response->getBody(),
        ];
    }
}
