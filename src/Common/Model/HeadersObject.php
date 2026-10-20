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
    public function __construct(
        /**
         * Заголовок для вибору мови посилання та сторінки відписки. Припустимі значення "be", "de", "en", "es", "fr",
         * "it", "pl", "pt", "ru", "ua", "kz".
         */
        public ?string $xALLYMAILERGlobalLanguage = null,
        /**
         * Заголовок для вибору шаблонізатора — або “simple”, або “velocity”, або “liquid”, або “none”. За замовчуванням
         * — “simple”. Має пріоритет над значенням, що передається в параметрі “template_engine”.
         */
        public ?string $xALLYMAILERTemplateEngine = null,
        /**
         * Поля окрім іменованих (будь-які інші ключі JSON-об'єкта): ім'я => значення. У разі збігу ключа перемагає
         * іменоване поле.
         *
         * @var array<string, string>
         */
        public array $extra = [],
    ) {
    }

    /**
     * @param array<string, mixed> $data Decoded JSON.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            xALLYMAILERGlobalLanguage: Data::string($data['X-ALLYMAILER-Global-Language'] ?? null),
            xALLYMAILERTemplateEngine: Data::string($data['X-ALLYMAILER-Template-Engine'] ?? null),
            extra: Data::extra($data, ['X-ALLYMAILER-Global-Language', 'X-ALLYMAILER-Template-Engine'], static fn ($item) => Data::string($item) ?? ''),
        );
    }

    /**
     * @return array<string, mixed> JSON-ready array: null fields are omitted, empty objects are \stdClass.
     */
    public function toArray(): array
    {
        return \array_filter([
            'X-ALLYMAILER-Global-Language' => $this->xALLYMAILERGlobalLanguage,
            'X-ALLYMAILER-Template-Engine' => $this->xALLYMAILERTemplateEngine,
        ], static fn (mixed $value): bool => $value !== null) + $this->extra;
    }

    /**
     * @return array<string, mixed>|\stdClass JSON object: {} when empty.
     */
    public function jsonSerialize(): mixed
    {
        return Data::object($this->toArray());
    }
}
