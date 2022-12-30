<?php

declare(strict_types=1);

namespace App\App;

use App\Domain\Task;
use App\Domain\TaskRepositoryInterface;
use App\Domain\Uuid;

class TaskService
{
    public function __construct(private readonly TaskRepositoryInterface $repo)
    {
    }

    public function getTask(string $id): ?Task
    {
        $uuid = Uuid::generate($id);

        return $this->repo->get($uuid);
    }

    /**
     * @return Task[]
     */
    public function listTasks(): array
    {
        return $this->repo->list();
    }

    public function saveTask(Task $task): void
    {
        $this->repo->save($task);
    }

    public function deleteTask(string $id): void
    {
        $uuid = Uuid::generate($id);

        $this->repo->delete($uuid);
    }

    public function toggleDoneTask(Task $task): Task
    {
        $task->toggleDone();

        $this->saveTask($task);

        return $task;
    }

    public function idIsValid(string $id): bool
    {
        return Uuid::isValid($id);
    }
}
