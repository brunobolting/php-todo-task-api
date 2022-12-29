<?php

declare(strict_types=1);

namespace App\Domain;

interface IDInterface
{
    public static function isValid(string $ID): bool;

    public function getAsString(): string;

    public function __toString(): string;
}
