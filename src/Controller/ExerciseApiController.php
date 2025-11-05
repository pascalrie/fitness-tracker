<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExerciseApiController extends BaseApiController
{
    #[Route('/exercise/api/create', name: 'create_exercise_api', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);

        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/exercise/api/list', name: 'list_exercise_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/exercise/api/show/{id}', name: 'show_exercise_api', methods: ['GET'])]
    public function show(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/exercise/api/update/{id}', name: 'update_exercise_api', methods: ['PUT'])]
    public function update(Request $request): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);

        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/exercise/api/delete/{id}', name: 'delete_exercise_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }
}
