<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

use AllyMailer\Client\Data;

/**
 * AttachmentsArrayItem
 */
final class AttachmentsArrayItem implements \JsonSerializable
{
    /**
     * Тип вкладення, див. [MIME](https://en.wikipedia.org/wiki/MIME). Якщо не впевнені, використовуйте
     * "application/octet-stream".
     * Приклад: `text/plain`.
     *
     * @var string
     */
    private $type;

    /**
     * Назва вкладення у форматі: "ім'я.розширення". У разі передачі кількох вкладень їхні назви мають бути
     * унікальними. У назві вкладень заборонено символ ‘/’.
     * Приклад: `readme.txt`.
     *
     * @var string
     */
    private $name;

    /**
     * Вміст файлу у [base64](https://en.wikipedia.org/wiki/Base64). Максимальний розмір файлу 7 Мб (9786710 байт у
     * base64).
     * Приклад: `SGVsbG8sIHdvcmxkIQ==`.
     *
     * @var string
     */
    private $content;

    public function __construct(string $type, string $name, string $content)
    {
        $this->type = $type;
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Data::string($data['type'] ?? null) ?? '',
            Data::string($data['name'] ?? null) ?? '',
            Data::string($data['content'] ?? null) ?? ''
        );
    }

    /**
     * Тип вкладення, див. [MIME](https://en.wikipedia.org/wiki/MIME).
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Тип вкладення, див. [MIME](https://en.wikipedia.org/wiki/MIME).
     *
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Назва вкладення у форматі: "ім'я.розширення".
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Назва вкладення у форматі: "ім'я.розширення".
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Вміст файлу у [base64](https://en.wikipedia.org/wiki/Base64).
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Вміст файлу у [base64](https://en.wikipedia.org/wiki/Base64).
     *
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'type' => $this->type,
            'name' => $this->name,
            'content' => $this->content,
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
