<?php

declare(strict_types=1);

namespace App\App;

use App\Domain\Task;
use App\Domain\TaskNotFoundException;
use App\Domain\TaskPersistenceException;
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

    /**
     * @throws TaskPersistenceException
     */
    public function saveTask(Task $task): void
    {
        try {
            $this->repo->save($task);
        } catch (\Exception $e) {
            throw new TaskPersistenceException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws TaskPersistenceException
     * @throws TaskNotFoundException
     */
    public function deleteTask(string $id): void
    {
        $uuid = Uuid::generate($id);
        try {
            $this->repo->delete($uuid);
        } catch (TaskNotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new TaskPersistenceException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws TaskPersistenceException
     */
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
