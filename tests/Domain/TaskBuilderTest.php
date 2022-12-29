<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\IDInterface;
use App\Domain\Task;
use App\Domain\TaskBuilder;
use PHPUnit\Framework\TestCase;

class TaskBuilderTest extends TestCase
{
    private string $id;
    private string $description;
    private \DateTimeInterface $dateCreated;

    public function setUp(): void
    {
        $this->description = 'create a test for a new feature';
        $this->id = '123e4567-e89b-12d3-a456-426655440000';
        $this->dateCreated = new \DateTimeImmutable();
    }

    public function testTaskBuildShouldBeWork(): void
    {
        $taskBuilder = new TaskBuilder($this->description);
        $taskBuilder->fromId($this->id)
            ->fromDateCreated($this->dateCreated)
            ->fromIsDone(true);

        $task = $taskBuilder->build();

        self::assertEquals($this->id, (string) $taskBuilder->getId());
        self::assertEquals($this->description, $taskBuilder->getDescription());
        self::assertEquals($this->dateCreated, $taskBuilder->getDateCreated());
        self::assertTrue($taskBuilder->isDone());
        self::assertInstanceOf(Task::class, $task);
    }

    public function testDefaultDataShouldBeGenerated(): void
    {
        $taskBuilder = new TaskBuilder($this->description);

        self::assertInstanceOf(IDInterface::class, $taskBuilder->getId());
        self::assertInstanceOf(\DateTimeInterface::class, $taskBuilder->getDateCreated());
        self::assertFalse($taskBuilder->isDone());
    }
}
