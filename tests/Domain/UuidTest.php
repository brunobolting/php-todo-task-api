<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\IDInterface;
use App\Domain\Uuid;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Uuid
 */
class UuidTest extends TestCase
{
    public function testCreateAnIDShouldBeWork(): void
    {
        $id = '123e4567-e89b-12d3-a456-426655440000';

        $uuid = Uuid::generate();
        $uuid2 = Uuid::generate($id);

        self::assertInstanceOf(IDInterface::class, $uuid);
        self::assertInstanceOf(IDInterface::class, $uuid2);
        self::assertEquals($id, $uuid2->getAsString());
        self::assertEquals($id, (string) $uuid2);
    }

    public function testInvalidUuidShouldBeThrowAnError(): void
    {
        $invalidId = 'aaaa2';

        self::expectException(\Exception::class);

        Uuid::generate($invalidId);
    }

    public function testUuidValidatorShouldBeWork(): void
    {
        $validUuid = '123e4567-e89b-12d3-a456-426655440000';
        $invalidUuid = '123456-7890123';

        self::assertTrue(Uuid::isValid($validUuid));
        self::assertFalse(Uuid::isValid($invalidUuid));
    }
}
