<?php

namespace App\Controller;

use App\Service\ExerciseService;
use App\Service\SetService;
use App\Service\WorkoutService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SetApiController extends BaseApiController
{
    protected SetService $setService;

    protected ExerciseService $exerciseService;

    protected WorkoutService $workoutService;

    public function __construct(EntityManagerInterface $entityManager, SetService $setService, ExerciseService $exerciseService,
                                WorkoutService         $workoutService)
    {
        parent::__construct($entityManager);
        $this->setService = $setService;
        $this->exerciseService = $exerciseService;
        $this->workoutService = $workoutService;
    }

    /**
     * @throws \Exception
     */
    #[Route('/api/set/create', name: 'create_set_api', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);
        $exerciseName = $bodyParameters->exerciseName;
        $repetitions = $bodyParameters->repetitions;

        $exercise = $this->exerciseService->showByUniqueName($exerciseName);
        $workout = $this->workoutService->findLatest();
        $set = $this->setService->create($exercise, $workout, (int) $repetitions);
        return $this->json($set->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/set/list', name: 'list_set_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $sets = $this->setService->list();
        $setsArray = [];
        foreach ($sets as $set) {
            $setsArray[] = $set->jsonSerialize();
        }
        return $this->json($setsArray, Response::HTTP_OK);
    }

    #[Route('/api/set/show/{id}', name: 'show_set_api', methods: ['GET'])]
    public function show(int $setId): JsonResponse
    {
        $set = $this->setService->show($setId);
        return $this->json($set->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/set/delete/{id}', name: 'delete_set_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->setService->delete($id);
        $shouldBeNull = $this->setService->show($id);
        if (null !== $shouldBeNull) {
            return $this->json('Set with id ' . $id . ' failed to get deleted', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json('Set with id ' . $id . ' was successfully deleted', Response::HTTP_OK);
    }

    /**
     * @throws \Exception
     */
    #[Route('/api/set/update/{id}', name: 'update_set_api', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);
        $newExerciseName = $bodyParameters->exerciseName;
        $newRepetitions = $bodyParameters->repetitions;
        $addExecution = $bodyParameters->executionId;
        $workout = $bodyParameters->workoutId;
        $exercise = $this->exerciseService->showByUniqueName($newExerciseName);
        $updatedSet = $this->setService->update($id, $exercise, $addExecution, $newRepetitions, $workout);

        return $this->json($updatedSet->jsonSerialize(), Response::HTTP_OK);
    }
}
