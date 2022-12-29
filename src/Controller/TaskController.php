<?php

declare(strict_types=1);

namespace App\Controller;

use App\App\TaskService;
use App\Domain\Task;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController
{
    public function __construct(readonly TaskService $taskService)
    {
    }

    public function index(): Response
    {
        return new Response('ok');
    }

    public function createTask(Request $request): JsonResponse
    {
        $description = $request->request->get('description');
        if ($description === null) {
            return new JsonResponse([
                'success' => false,
                'message' => 'description cannot be empty',
                'data' => []
            ], Response::HTTP_BAD_REQUEST);
        }

        $task = Task::create($description)->build();

        $this->taskService->saveTask($task);

        return new JsonResponse([
            'success' => true,
            'message' => 'task created successfully',
            'data' => $task
        ]);
    }

    public function listTasks(): JsonResponse
    {
        $tasks = $this->taskService->listTasks();

        return new JsonResponse([
            'success' => true,
            'message' => 'tasks fetched successfully',
            'data' => $tasks
        ]);
    }

    public function getTask(string $id): JsonResponse
    {
        if (!$this->taskService->idIsValid($id)) {
            return new JsonResponse([
                'success' => false,
                'message' => 'id provided is invalid',
                'data' => []
            ], Response::HTTP_BAD_REQUEST);
        }

        $task = $this->taskService->getTask($id);

        if ($task === null) {
            return new JsonResponse([
                'success' => false,
                'message' => 'task not found',
                'data' => []
            ], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'success' => true,
            'message' => 'task fetched successfully',
            'data' => $task
        ]);
    }

    public function updateTask()
    {

    }

    public function deleteTask()
    {

    }
}
