<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BodyMeasurementApiController extends BaseApiController
{
    #[Route('/body/measurement/api/create', name: 'create_body_measurement_api', methods: ['POST'])]
    public function create(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/body/measurement/api/list', name: 'list_body_measurement_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/body/measurement/api/show/{id}', name: 'show_body_measurement_api', methods: ['GET'])]
    public function show(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/body/measurement/api/update/{id}', name: 'update_body_measurement_api', methods: ['PUT'])]
    public function update(): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/body/measurement/api/delete/{id}', name: 'delete_body_measurement_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return $this->json(["not implemented"], Response::HTTP_NOT_IMPLEMENTED);
    }
}
