<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт, що містить у собі html-, plaintext- і amp-частини листа. Або html-, або plaintext-частина має бути
 * присутня обов'язково.
 */
final class BodyObject implements \JsonSerializable
{
    public function __construct(
        /**
         * HTML-частина листа
         * Приклад: `<b>Hello, &#7b;&#7b;to_name&#7c;&#7c;</b>`.
         */
        public ?string $html = null,
        /**
         * Plaintext-частина листа.
         * Приклад: `Hello, &#7b;&#7b;to_name&#7c;&#7c;`.
         */
        public ?string $plaintext = null,
        /**
         * Необов'язкова [AMP](http://amp.dev/documentation/guides-and-tutorials/learn/email_fundamentals/)-частина
         * листа.
         * Приклад: `<!doctype html><html amp4email><head> <meta charset="utf-8"><script async
         * src="https://cdn.ampproject.org/v0.js"></script> <style
         * amp4email-boilerplate>body{visibility:hidden}</style></head><body> Hello, AMP4EMAIL world.</body></html>`.
         */
        public ?string $amp = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            html: Data::string($data['html'] ?? null),
            plaintext: Data::string($data['plaintext'] ?? null),
            amp: Data::string($data['amp'] ?? null),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'html' => $this->html,
            'plaintext' => $this->plaintext,
            'amp' => $this->amp,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    public function jsonSerialize(): mixed
    {
        return Data::object($this->toArray());
    }
}
