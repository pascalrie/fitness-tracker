<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MuscleGroupApiController extends BaseApiController
{
    #[Route('/muscle/group/api/create', name: 'create_muscle_group_api', methods: ['POST'])]
    public function create(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/muscle/group/api/list', name: 'list_muscle_group_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/muscle/group/api/show/{id}', name: 'show_muscle_group_api', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/muscle/group/api/update/{id}', name: 'update_muscle_group_api', methods: ['PUT'])]
    public function update(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/muscle/group/api/delete/{id}', name: 'delete_muscle_group_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }
}
