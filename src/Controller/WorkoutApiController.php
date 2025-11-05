<?php

namespace App\Controller;

use App\Service\WorkoutService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class WorkoutApiController extends BaseApiController
{
    protected WorkoutService $workoutService;

    public function __construct(EntityManagerInterface $entityManager, WorkoutService $workoutService)
    {
        parent::__construct($entityManager);
        $this->workoutService = $workoutService;
    }

    #[Route('/workout/create', name: 'create_workout_api', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $bodyParameters = json_decode($request->getContent());
        $stretch = (bool) $bodyParameters->stretch;
        $bodyWeight = (float) $bodyParameters->weight;

        $workout = $this->workoutService->create($stretch, $bodyWeight);
        return $this->json($workout->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/workout/create', name: 'create_workout_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $workouts = $this->workoutService->list();
        $workoutArray = [];
        foreach ($workouts as $workout) {
            $workoutArray[] = $workout->jsonSerialize();
        }
        return $this->json($workoutArray, Response::HTTP_OK);
    }

    #[Route('/workout/create', name: 'create_workout_api', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $bodyParameters = json_decode($request->getContent());
        $updatedStretch = (bool) $bodyParameters->stretch;
        $updatedBodyWeight = (float) $bodyParameters->weight;

        $updatedWorkout = $this->workoutService->update($id, $updatedStretch, $updatedBodyWeight);
        return $this->json($updatedWorkout->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/workout/create', name: 'create_workout_api', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $workout = $this->workoutService->show($id);
        return $this->json($workout->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/workout/api/delete/{id}', name: 'delete_workout_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->workoutService->delete($id);
        $shouldBeNull = $this->workoutService->show($id);
        if (null !== $shouldBeNull) {
            return $this->json('Deletion failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json('Deletion was successful.', Response::HTTP_OK);
    }
}
