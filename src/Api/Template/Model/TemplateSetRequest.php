<?php

declare(strict_types=1);

namespace AllyMailer\Api\Template\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт з усіма властивостями шаблону.
 */
final class TemplateSetRequest implements \JsonSerializable
{
    public function __construct(
        /**
         * Об'єкт, що містить властивості шаблону.
         */
        public TemplateObject $template,
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            template: TemplateObject::fromArray(Data::array($data['template'] ?? null) ?? []),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'template' => Data::object($this->template->toArray()),
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
