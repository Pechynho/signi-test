<?php

namespace App\Utils;

final readonly class Strings
{
    private function __construct() {}

    public static function isNullOrWhiteSpace(?string $value): bool
    {
        return $value === null || trim($value) === '';
    }
}
