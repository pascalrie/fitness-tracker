<?php

namespace App\Controller;

use App\Service\MuscleGroupService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MuscleGroupApiController extends BaseApiController
{
    protected MuscleGroupService $muscleGroupService;

    public function __construct(EntityManagerInterface $entityManager, MuscleGroupService $muscleGroupService)
    {
        parent::__construct($entityManager);
        $this->muscleGroupService = $muscleGroupService;
    }

    #[Route('/api/muscle/group/create', name: 'create_muscle_group_api', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);
        $name = $bodyParameters->name;

        $muscleGroup = $this->muscleGroupService->create($name);

        return $this->json($muscleGroup->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/muscle/group/list', name: 'list_muscle_group_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $muscleGroups = $this->muscleGroupService->list();
        $groups = [];
        foreach ($muscleGroups as $muscleGroup) {
            $groups[] = $muscleGroup->jsonSerialize();
        }
        return $this->json($groups, Response::HTTP_OK);
    }

    #[Route('/api/muscle/group/show/{id}', name: 'show_muscle_group_api', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $muscleGroup = $this->muscleGroupService->show($id);
        return $this->json($muscleGroup->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/muscle/group/update/{id}', name: 'update_muscle_group_api', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);
        $name = $bodyParameters->name;
        $newExerciseUniqueNames = $bodyParameters->newExerciseNames;

        $muscleGroup = $this->muscleGroupService->update($id, $name, $newExerciseUniqueNames);
        return $this->json($muscleGroup->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/muscle/group/delete/{id}', name: 'delete_muscle_group_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->muscleGroupService->delete($id);
        $shouldBeNull = $this->muscleGroupService->show($id);
        if (null !== $shouldBeNull) {
            return $this->json("Deletion of Muscle Group with id: " . $id . " failed.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json("Deletion was successful.", Response::HTTP_OK);
    }
}
