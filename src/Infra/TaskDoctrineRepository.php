<?php

declare(strict_types=1);

namespace App\Infra;

use App\Domain\IDInterface;
use App\Domain\Task;
use App\Domain\TaskNotFoundException;
use App\Domain\TaskRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class TaskDoctrineRepository implements TaskRepositoryInterface
{
    public function __construct(readonly EntityManagerInterface $entityManager)
    {
    }

    public function get(IDInterface $ID): ?Task
    {
        return $this->entityManager->getRepository(Task::class)->findOneBy(['id' => (string) $ID]);
    }

    public function list(): array
    {
        return $this->entityManager->getRepository(Task::class)->findAll();
    }

    public function save(Task $task): void
    {
        $this->entityManager->persist($task);

        $this->entityManager->flush();
    }


    public function delete(IDInterface $ID): void
    {
        $task = $this->get($ID);

        if ($task === null) {
            throw new TaskNotFoundException();
        }

        $this->entityManager->remove($task);

        $this->entityManager->flush();
    }
}
