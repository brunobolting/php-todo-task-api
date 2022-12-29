<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeInterface;

class TaskBuilder
{
    private IDInterface $id;

    private DateTimeInterface $dateCreated;

    private bool $isDone;

    private string $description;

    public function __construct(string $description)
    {
        $this->id = Uuid::generate();
        $this->description = $description;
        $this->dateCreated = new \DateTimeImmutable();
        $this->isDone = false;
    }

    public function fromId(string $id): self
    {
        $this->id = Uuid::generate($id);

        return $this;
    }

    public function fromDateCreated(DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function fromIsDone(bool $isDone): self
    {
        $this->isDone = $isDone;

        return $this;
    }

    public function build(): Task
    {
        return new Task($this);
    }

    /**
     * @return IDInterface
     */
    public function getId(): IDInterface
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDateCreated(): DateTimeInterface
    {
        return $this->dateCreated;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
