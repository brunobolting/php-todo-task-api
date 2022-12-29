<?php

declare(strict_types=1);

namespace App\Infra;

use App\Domain\IDInterface;
use App\Domain\Uuid;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class UuidDoctrineType extends Type
{
    private const UUID = 'uuid';

    private const DATABASE_COLUMN = 'id';

    public function getName(): string
    {
        return self::UUID;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return self::DATABASE_COLUMN;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): IDInterface
    {
        return Uuid::generate($value);
    }
}
