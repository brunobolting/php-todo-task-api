<?php

namespace App\Infra;

use App\Domain\IDInterface;
use App\Domain\Task;
use App\Domain\TaskRepositoryInterface;

final class TaskInMemoryRepository implements TaskRepositoryInterface
{
    public function __construct(private array $tasks = [])
    {
    }

    public function get(IDInterface $ID): ?Task
    {
        if (!array_key_exists($ID->getAsString(), $this->tasks)) {
            return null;
        }

        return $this->tasks[$ID->getAsString()];
    }

    public function list(): array
    {
        return array_values($this->tasks);
    }

    public function save(Task $task): void
    {
        $this->tasks[(string) $task->getId()] = $task;
    }

    public function delete(IDInterface $ID): void
    {
        unset($this->tasks[$ID->getAsString()]);
    }
}
