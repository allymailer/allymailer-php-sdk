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
    /**
     * HTML-частина листа
     * Приклад: `<b>Hello, &#7b;&#7b;to_name&#7c;&#7c;</b>`.
     *
     * @var string|null
     */
    private $html;

    /**
     * Plaintext-частина листа.
     * Приклад: `Hello, &#7b;&#7b;to_name&#7c;&#7c;`.
     *
     * @var string|null
     */
    private $plaintext;

    /**
     * Необов'язкова [AMP](http://amp.dev/documentation/guides-and-tutorials/learn/email_fundamentals/)-частина
     * листа.
     * Приклад: `<!doctype html><html amp4email><head> <meta charset="utf-8"><script async
     * src="https://cdn.ampproject.org/v0.js"></script> <style
     * amp4email-boilerplate>body{visibility:hidden}</style></head><body> Hello, AMP4EMAIL world.</body></html>`.
     *
     * @var string|null
     */
    private $amp;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->html = Data::string($data['html'] ?? null);
        $model->plaintext = Data::string($data['plaintext'] ?? null);
        $model->amp = Data::string($data['amp'] ?? null);

        return $model;
    }

    /**
     * HTML-частина листа
     */
    public function getHtml(): ?string
    {
        return $this->html;
    }

    /**
     * HTML-частина листа
     *
     * @return $this
     */
    public function setHtml(?string $html): self
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Plaintext-частина листа.
     */
    public function getPlaintext(): ?string
    {
        return $this->plaintext;
    }

    /**
     * Plaintext-частина листа.
     *
     * @return $this
     */
    public function setPlaintext(?string $plaintext): self
    {
        $this->plaintext = $plaintext;

        return $this;
    }

    /**
     * Необов'язкова [AMP](http://amp.dev/documentation/guides-and-tutorials/learn/email_fundamentals/)-частина
     * листа.
     */
    public function getAmp(): ?string
    {
        return $this->amp;
    }

    /**
     * Необов'язкова [AMP](http://amp.dev/documentation/guides-and-tutorials/learn/email_fundamentals/)-частина
     * листа.
     *
     * @return $this
     */
    public function setAmp(?string $amp): self
    {
        $this->amp = $amp;

        return $this;
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
        ], static function ($value): bool {
            return $value !== null;
        });
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return Data::object($this->toArray());
    }
}
