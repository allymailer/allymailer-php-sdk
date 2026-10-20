<?php

declare(strict_types=1);

namespace AllyMailer\Client;

/**
 * Conversions between the models and decoded JSON, used by the generated models.
 *
 * - reading is lenient: a missing field or a value of another type never breaks a response, it becomes null
 *   (the models put the default of the type for the required fields);
 * - writing keeps JSON objects as objects: an empty model or map is a \stdClass, so json_encode() gives {}.
 *
 * @internal
 */
final class Data
{
    /**
     * @param mixed $value
     */
    public static function string($value): ?string
    {
        if (\is_string($value)) {
            return $value;
        }
        if (\is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return \is_int($value) || \is_float($value) ? (string)$value : null;
    }

    /**
     * @param mixed $value
     */
    public static function int($value): ?int
    {
        if (\is_int($value)) {
            return $value;
        }
        if (\is_bool($value)) {
            return (int)$value;
        }
        if (\is_string($value) && \is_numeric($value)) {
            $value = (float)$value;
        }
        if (\is_float($value) && \is_finite($value) && \abs($value) < 9.2E18) {
            return (int)$value;
        }

        return null;
    }

    /**
     * @param mixed $value
     */
    public static function float($value): ?float
    {
        if (\is_float($value) || \is_int($value) || \is_bool($value) || (\is_string($value) && \is_numeric($value))) {
            return (float)$value;
        }

        return null;
    }

    /**
     * @param mixed $value
     */
    public static function bool($value): ?bool
    {
        if (\is_bool($value)) {
            return $value;
        }
        if (\is_int($value) || \is_float($value)) {
            return 0 != $value;
        }
        if (\is_string($value)) {
            return !\in_array(\strtolower(\trim($value)), ['', '0', 'false', 'no', 'off', 'null'], true);
        }

        return null;
    }

    /**
     * A JSON object or array: an array (a \stdClass becomes one), null for any other value.
     *
     * @param mixed $value
     *
     * @return array<array-key, mixed>|null
     */
    public static function array($value): ?array
    {
        if (\is_array($value)) {
            return $value;
        }

        return $value instanceof \stdClass ? (array)$value : null;
    }

    /**
     * @param mixed $value
     * @param callable|null $item Conversion of every item.
     *
     * @return list<mixed>|null
     */
    public static function list($value, ?callable $item = null): ?array
    {
        $value = self::array($value);
        if (null === $value) {
            return null;
        }
        $value = \array_values($value);

        return null === $item ? $value : \array_map($item, $value);
    }

    /**
     * @param mixed $value
     * @param callable|null $item Conversion of every value.
     *
     * @return array<array-key, mixed>|null
     */
    public static function map($value, ?callable $item = null): ?array
    {
        $value = self::array($value);
        if (null === $value || null === $item) {
            return $value;
        }

        return \array_map($item, $value);
    }

    /**
     * A model from a JSON object, null when the value is not an object.
     *
     * @template T of object
     *
     * @param class-string<T> $class
     * @param mixed $value
     *
     * @return T|null
     */
    public static function model(string $class, $value)
    {
        $value = self::array($value);

        return null === $value ? null : $class::fromArray($value);
    }

    /**
     * The keys of a JSON object beyond the named fields of a model.
     *
     * @param array<array-key, mixed> $data
     * @param list<string> $known Wire names of the named fields.
     * @param callable|null $item Conversion of every value.
     *
     * @return array<string, mixed>
     */
    public static function extra(array $data, array $known, ?callable $item = null): array
    {
        $extra = \array_diff_key($data, \array_flip($known));

        return null === $item ? $extra : \array_map($item, $extra);
    }

    /**
     * A JSON object for json_encode(): an empty array becomes a \stdClass ({} instead of []).
     *
     * @param array<array-key, mixed>|null $value
     *
     * @return array<array-key, mixed>|\stdClass|null
     */
    public static function object(?array $value)
    {
        return [] === $value ? new \stdClass() : $value;
    }

    /**
     * A case of a backed enum; a value the enum does not know (added to the API later) is kept as is.
     *
     * @template T of \BackedEnum
     *
     * @param class-string<T> $class
     *
     * @return T|string|int|null
     */
    public static function enum(string $class, string|int|null $value): \BackedEnum|string|int|null
    {
        return null === $value ? null : ($class::tryFrom($value) ?? $value);
    }

    /**
     * The JSON value of an enum field: the value of a case, any other value as is.
     *
     * @return mixed
     */
    public static function value(mixed $value): mixed
    {
        if (\is_array($value)) {
            return \array_map([self::class, 'value'], $value);
        }

        return $value instanceof \BackedEnum ? $value->value : $value;
    }
}
