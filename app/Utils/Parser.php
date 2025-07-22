<?php

namespace App\Utils;

namespace App\Utils;

class Parser
{

    public static function parseString(array $stack, string $needle, string $default = ''): string
    {
        if (!array_key_exists($needle, $stack)) {
            return $default;
        }

        $value = $stack[$needle];

        return is_string($value) ? $value : (string) $value;
    }


    public static function parseInt(array $stack, string $needle, int $default = 0): int
    {
        if (!array_key_exists($needle, $stack)) {
            return $default;
        }

        return (int) $stack[$needle];
    }

    public static function parseNullableInt(array $stack, string $needle): ?int
    {
        if (!array_key_exists($needle, $stack)) {
            return null;
        }

        $value = $stack[$needle];

        if (is_null($value) || $value === '') {
            return null;
        }

        return (int) $value;
    }

    public static function parseBool(array $stack, string $needle, bool $default = false): bool
    {
        if (!array_key_exists($needle, $stack)) {
            return $default;
        }

        return filter_var($stack[$needle], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? $default;
    }


    public static function parseFloat(array $stack, string $needle, float $default = 0.0): float
    {
        if (!array_key_exists($needle, $stack)) {
            return $default;
        }

        return (float) $stack[$needle];
    }
}

