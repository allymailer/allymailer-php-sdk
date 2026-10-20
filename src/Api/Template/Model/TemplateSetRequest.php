<?php

declare(strict_types=1);

namespace AllyMailer\Api\Template\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт з усіма властивостями шаблону.
 */
final class TemplateSetRequest implements \JsonSerializable
{
    /**
     * Об'єкт, що містить властивості шаблону.
     *
     * @var TemplateObject
     */
    private $template;

    public function __construct(TemplateObject $template)
    {
        $this->template = $template;
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(TemplateObject::fromArray(Data::array($data['template'] ?? null) ?? []));
    }

    /**
     * Об'єкт, що містить властивості шаблону.
     */
    public function getTemplate(): TemplateObject
    {
        return $this->template;
    }

    /**
     * Об'єкт, що містить властивості шаблону.
     *
     * @return $this
     */
    public function setTemplate(TemplateObject $template): self
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'template' => Data::object($this->template->toArray()),
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
