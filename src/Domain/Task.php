<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeInterface;

class Task implements EntityInterface
{
    readonly IDInterface $id;

    private string $description;

    readonly DateTimeInterface $dateCreated;

    private bool $isDone;

    public function __construct(TaskBuilder $builder) {
        $this->id = $builder->getId();
        $this->description = $builder->getDescription();
        $this->dateCreated = $builder->getDateCreated();
        $this->isDone = $builder->isDone();
    }

    public static function create(string $description): TaskBuilder
    {
        return new TaskBuilder($description);
    }

    public function toggleDone(): void
    {
        $this->isDone = !$this->isDone;
    }

    public function getId(): IDInterface
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDateCreated(): DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function isDone(): bool
    {
        return $this->isDone;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => (string) $this->id,
            'description' => $this->description,
            'dateCreated' => $this->dateCreated->format('Y-m-d H:i:s'),
            'isDone' => $this->isDone
        ];
    }
}
