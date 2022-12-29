<?php

declare(strict_types=1);

namespace App\Domain;

class TaskNotFoundException extends \Exception
{
    private const ERROR_CODE = 8888;

    private const ERROR_MESSAGE = 'task not found';

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE, self::ERROR_CODE);
    }
}
