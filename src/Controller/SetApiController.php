<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SetApiController extends BaseApiController
{
    #[Route('/set/api/create', name: 'create_set_api', methods: ['POST'])]
    public function create(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/set/api/list', name: 'list_set_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/set/api/update/{id}', name: 'update_set_api', methods: ['PUT'])]
    public function update(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/set/api/show/{id}', name: 'show_set_api', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/set/api/delete/{id}', name: 'delete_set_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }
}
