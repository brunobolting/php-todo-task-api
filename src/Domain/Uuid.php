<?php

declare(strict_types=1);

namespace App\Domain;

final class Uuid implements IDInterface
{
    private function __construct(private readonly \Symfony\Component\Uid\Uuid $uuid)
    {
    }

    public static function generate(?string $ID = null): self
    {
        if ($ID === null) {
            return new self(\Symfony\Component\Uid\Uuid::v4());
        }

        return new self(\Symfony\Component\Uid\Uuid::fromString($ID));
    }

    public static function isValid(string $ID): bool
    {
        return \Symfony\Component\Uid\Uuid::isValid($ID);
    }

    public function getAsString(): string
    {
        return $this->uuid->toRfc4122();
    }

    public function __toString(): string
    {
        return $this->uuid->toRfc4122();
    }
}
