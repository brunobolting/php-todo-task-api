<?php

declare(strict_types=1);

namespace App\Domain;

interface TaskRepositoryInterface
{
    public function get(IDInterface $ID): ?Task;

    /** @return Task[] */
    public function list(): array;

    public function save(Task $task): void;

    public function delete(IDInterface $ID): void;
}
