<?php

declare(strict_types=1);

namespace AllyMailer\Common\Model;

use AllyMailer\Client\Data;

/**
 * Об'єкт, що містить додаткові заголовки листа, максимум 50 заголовків. Префікс “X-” в імені заголовка
 * обов'язковий, заголовки без нього будуть проігноровані, наприклад X-ALLYMAILER-Global-Language,
 * X-ALLYMAILER-Template-Engine. Стандартні заголовки "To", "CC", "BCC" передаються без префікса "X-", але
 * обробляються спеціальним чином, тому мають низку обмежень, докладніше про це можна прочитати
 * [тут](/cc-and-bcc). Також якщо [техпідтримка](https://cp.allymailer.com/ua/support) схвалила вам вимкнення
 * посилання відписки, то ви також можете передавати заголовки List-Unsubscribe, List-Subscribe, List-Help,
 * List-Owner, List-Archive, In-Reply-To і References.
 */
final class HeadersObject implements \JsonSerializable
{
    /**
     * Заголовок для вибору мови посилання та сторінки відписки. Припустимі значення "be", "de", "en", "es", "fr",
     * "it", "pl", "pt", "ru", "ua", "kz".
     *
     * @var string|null
     */
    private $xALLYMAILERGlobalLanguage;

    /**
     * Заголовок для вибору шаблонізатора — або “simple”, або “velocity”, або “liquid”, або “none”. За замовчуванням
     * — “simple”. Має пріоритет над значенням, що передається в параметрі “template_engine”.
     *
     * @var string|null
     */
    private $xALLYMAILERTemplateEngine;

    /**
     * Поля окрім іменованих (будь-які інші ключі JSON-об'єкта): ім'я => значення. У разі збігу ключа перемагає
     * іменоване поле.
     *
     * @var array<string, string>
     */
    private $extra = [];

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        $model = new self();
        $model->xALLYMAILERGlobalLanguage = Data::string($data['X-ALLYMAILER-Global-Language'] ?? null);
        $model->xALLYMAILERTemplateEngine = Data::string($data['X-ALLYMAILER-Template-Engine'] ?? null);
        $model->extra = Data::extra($data, ['X-ALLYMAILER-Global-Language', 'X-ALLYMAILER-Template-Engine'], static function ($item) { return Data::string($item) ?? ''; });

        return $model;
    }

    /**
     * Заголовок для вибору мови посилання та сторінки відписки.
     */
    public function getXALLYMAILERGlobalLanguage(): ?string
    {
        return $this->xALLYMAILERGlobalLanguage;
    }

    /**
     * Заголовок для вибору мови посилання та сторінки відписки.
     *
     * @return $this
     */
    public function setXALLYMAILERGlobalLanguage(?string $xALLYMAILERGlobalLanguage): self
    {
        $this->xALLYMAILERGlobalLanguage = $xALLYMAILERGlobalLanguage;

        return $this;
    }

    /**
     * Заголовок для вибору шаблонізатора — або “simple”, або “velocity”, або “liquid”, або “none”.
     */
    public function getXALLYMAILERTemplateEngine(): ?string
    {
        return $this->xALLYMAILERTemplateEngine;
    }

    /**
     * Заголовок для вибору шаблонізатора — або “simple”, або “velocity”, або “liquid”, або “none”.
     *
     * @return $this
     */
    public function setXALLYMAILERTemplateEngine(?string $xALLYMAILERTemplateEngine): self
    {
        $this->xALLYMAILERTemplateEngine = $xALLYMAILERTemplateEngine;

        return $this;
    }

    /**
     * Поля окрім іменованих (будь-які інші ключі JSON-об'єкта): ім'я => значення.
     *
     * @return array<string, string>
     */
    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * Задає поля окрім іменованих: ім'я => значення. У разі збігу ключа перемагає іменоване поле.
     *
     * @param array<string, string> $extra
     *
     * @return $this
     */
    public function setExtra(array $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'X-ALLYMAILER-Global-Language' => $this->xALLYMAILERGlobalLanguage,
            'X-ALLYMAILER-Template-Engine' => $this->xALLYMAILERTemplateEngine,
        ], static function ($value): bool {
            return $value !== null;
        }) + $this->extra;
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
