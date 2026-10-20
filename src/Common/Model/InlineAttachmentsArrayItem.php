<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

use AllyMailer\Client\Data;

/**
 * InlineAttachmentsArrayItem
 */
final class InlineAttachmentsArrayItem implements \JsonSerializable
{
    public function __construct(
        /**
         * Тип вкладення, див. [MIME](https://en.wikipedia.org/wiki/MIME). Якщо не впевнені, використовуйте
         * "application/octet-stream".
         * Приклад: `image/gif`.
         */
        public string $type,
        /**
         * Ідентифікатор вкладення. Якщо, наприклад, "name"="IMAGECID", то для виведення картинки з цього вкладення в
         * HTML-тексті листа потрібно вказати <img src="cid:IMAGECID">.
         * Приклад: `IMAGECID1`.
         */
        public string $name,
        /**
         * Вміст файлу у [base64](https://en.wikipedia.org/wiki/Base64). Максимальний розмір файлу 7 Мб (9786710 байт у
         * base64).
         * Приклад: `R0lGODdhAwADAIABAP+rAP///ywAAAAAAwADAAACBIQRBwUAOw==`.
         */
        public string $content,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            type: Data::string($data['type'] ?? null) ?? '',
            name: Data::string($data['name'] ?? null) ?? '',
            content: Data::string($data['content'] ?? null) ?? '',
        );
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
