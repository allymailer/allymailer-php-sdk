<?php

declare(strict_types=1);

namespace AllyMailer\Api\Template\Model;

use AllyMailer\Client\Data;

/**
 * TemplateGetResponse
 */
final class TemplateGetResponse implements \JsonSerializable
{
    /**
     * Рядок "success".
     * Допустимі значення: `success`.
     *
     * @var string|null
     */
    private $status;

    /**
     * Об'єкт, що містить властивості шаблону.
     *
     * @var TemplateObject|null
     */
    private $template;

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->status = Data::string($data['status'] ?? null);
        $model->template = Data::model(TemplateObject::class, $data['template'] ?? null);

        return $model;
    }

    /**
     * Рядок "success".
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Рядок "success".
     *
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Об'єкт, що містить властивості шаблону.
     */
    public function getTemplate(): ?TemplateObject
    {
        return $this->template;
    }

    /**
     * Об'єкт, що містить властивості шаблону.
     *
     * @return $this
     */
    public function setTemplate(?TemplateObject $template): self
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
            'status' => $this->status,
            'template' => null === $this->template ? null : Data::object($this->template->toArray()),
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
