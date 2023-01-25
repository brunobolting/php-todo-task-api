<?php

declare(strict_types=1);

namespace App\Tests\App;

use App\App\TaskService;
use App\Domain\Task;
use App\Domain\TaskNotFoundException;
use App\Domain\TaskPersistenceException;
use App\Domain\TaskRepositoryInterface;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    private TaskRepositoryInterface $repo;

    private Task $task;

    private string $id;

    private TaskService $taskService;

    public function setUp(): void
    {
        $this->id = '123e4567-e89b-12d3-a456-426655440000';

        $this->task = Task::create('test')->fromId($this->id)->fromIsDone(false)->build();

        $this->repo = self::createMock(TaskRepositoryInterface::class);

        $this->taskService = new TaskService($this->repo);
    }

    public function testGetTaskShouldBeWork(): void
    {
        $this->repo->method('get')->willReturn($this->task, null);

        $task = $this->taskService->getTask($this->id);
        $task2 = $this->taskService->getTask($this->id);

        self::assertInstanceOf(Task::class, $task);
        self::assertEquals($this->id, $task->getId());
        self::assertNull($task2);
    }

    public function testListTasksShouldBeWork(): void
    {
        $this->repo->method('list')->willReturn([$this->task, $this->task], []);

        $tasks = $this->taskService->listTasks();
        $tasks2 = $this->taskService->listTasks();

        self::assertIsArray($tasks);
        self::assertIsArray($tasks2);
        self::assertCount(2, $tasks);
        self::assertCount(0, $tasks2);
        self::assertInstanceOf(Task::class, $tasks[0]);
    }

    public function testSaveTaskCanThrowAnException(): void
    {
        $this->repo->method('save')->willThrowException(new \Exception());

        self::expectException(TaskPersistenceException::class);

        $this->taskService->saveTask($this->task);
    }

    public function testDeleteTaskCanThrowTaskNotFoundException(): void
    {
        $this->repo->method('delete')->willThrowException(new TaskNotFoundException());

        self::expectException(TaskNotFoundException::class);

        $this->taskService->deleteTask($this->id);
    }

    public function testDeleteTaskCanThrowTaskPersistentException(): void
    {
        $this->repo->method('delete')->willThrowException(new \Exception());

        self::expectException(TaskPersistenceException::class);

        $this->taskService->deleteTask($this->id);
    }

    public function testToggleDoneTaskShouldBeWork(): void
    {
        self::assertFalse($this->task->isDone());

        $this->task = $this->taskService->toggleDoneTask($this->task);
        self::assertTrue($this->task->isDone());

        $this->task = $this->taskService->toggleDoneTask($this->task);
        self::assertFalse($this->task->isDone());

        $this->task = $this->taskService->toggleDoneTask($this->task);
        self::assertTrue($this->task->isDone());

        $this->task = $this->taskService->toggleDoneTask($this->task);
        self::assertFalse($this->task->isDone());
    }

    public function testToggleDoneTaskCanThrowTaskPersistentException(): void
    {
        $this->repo->method('save')->willThrowException(new \Exception());

        self::expectException(TaskPersistenceException::class);

        $this->taskService->toggleDoneTask($this->task);
    }

    public function testIdIsValidShouldBeWork(): void
    {
        $validId = $this->taskService->idIsValid($this->id);
        $invalidId = $this->taskService->idIsValid('aaaa-uuuuu-123');

        self::assertTrue($validId);
        self::assertFalse($invalidId);
    }
}
