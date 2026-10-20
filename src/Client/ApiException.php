<?php

declare(strict_types=1);

namespace AllyMailer\Client;

/**
 * Thrown when the API returns an error or the response can not be processed.
 */
class ApiException extends \RuntimeException
{
    /**
     * @param array<string, mixed>|null $responseBody
     */
    public function __construct(
        string $message,
        private readonly int $httpStatus = 0,
        private readonly ?int $errorCode = null,
        private readonly ?array $responseBody = null,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $errorCode ?? $httpStatus, $previous);
    }

    /**
     * HTTP status code of the response, 0 when the request was not sent.
     */
    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * API error code (the "code" field of the error response).
     */
    public function getErrorCode(): ?int
    {
        return $this->errorCode;
    }

    /**
     * @return array<string, mixed>|null Decoded error response.
     */
    public function getResponseBody(): ?array
    {
        return $this->responseBody;
    }
}
