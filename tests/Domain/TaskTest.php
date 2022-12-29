<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\IDInterface;
use App\Domain\Task;
use App\Domain\TaskBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Task
 */
class TaskTest extends TestCase
{
    private string $id;
    private string $description;
    private \DateTimeInterface $dateCreated;
    private TaskBuilder $taskBuilder;

    public function setUp(): void
    {
        $this->description = 'create a test for a new feature';
        $this->id = '123e4567-e89b-12d3-a456-426655440000';
        $this->dateCreated = new \DateTimeImmutable();

        $this->taskBuilder = (new TaskBuilder($this->description))
            ->fromId($this->id)
            ->fromDateCreated($this->dateCreated);
    }

    public function testCreateNewTaskShouldBeWork(): void
    {
        $task = new Task($this->taskBuilder);

        self::assertEquals($this->id, (string) $task->getId());
        self::assertInstanceOf(IDInterface::class, $task->getId());
        self::assertEquals($this->description, $task->getDescription());
        self::assertEquals($this->dateCreated, $task->getDateCreated());
        self::assertFalse($task->isDone());
    }

    public function testNewTasksShouldNotBeDone(): void
    {
        $task = new Task($this->taskBuilder);

        self::assertFalse($task->isDone());
    }

    public function testToggleDoneShouldBeWork(): void
    {
        $task = new Task($this->taskBuilder);

        self::assertFalse($task->isDone());

        $task->toggleDone();

        self::assertTrue($task->isDone());

        $task->toggleDone();

        self::assertFalse($task->isDone());

        $task->toggleDone();

        self::assertTrue($task->isDone());
    }

    public function testTaskBuilderShouldBeWork(): void
    {
        $task = Task::create($this->description)->build();

        self::assertInstanceOf(Task::class, $task);
        self::assertEquals($this->description, $task->getDescription());
    }
}
