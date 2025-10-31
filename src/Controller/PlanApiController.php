<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlanApiController extends BaseApiController
{
    #[Route('/plan/api/create', name: 'create_plan_api', methods: ['POST'])]
    public function create(): Response
    {
        return $this->json(['not implemented'], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/plan/api/list', name: 'list_plan_api', methods: ['GET'])]
    public function list(): Response
    {
        return $this->json(['not implemented'], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/plan/api/show/{id}', name: 'show_plan_api', methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->json(['not implemented'], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/plan/api/update/{id}', name: 'update_plan_api', methods: ['PUT'])]
    public function update(int $id): Response
    {
        return $this->json(['not implemented'], Response::HTTP_NOT_IMPLEMENTED);
    }

    #[Route('/plan/api/delete/{id}', name: 'delete_plan_api', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        return $this->json(['not implemented'], Response::HTTP_NOT_IMPLEMENTED);
    }
}
