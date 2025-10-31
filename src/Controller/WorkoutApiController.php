<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WorkoutApiController extends BaseApiController
{
    #[Route('/workout/create', name: 'create_workout_api', methods: ['POST'])]
    public function create(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/workout/create', name: 'create_workout_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/workout/create', name: 'create_workout_api', methods: ['PUT'])]
    public function update(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/workout/create', name: 'create_workout_api', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/workout/api/delete/{id}', name: 'delete_workout_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }
}
