<?php

namespace App\Controller;

use App\Service\ExerciseService;
use App\Service\ExecutionService;
use App\Service\WorkoutService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExecutionApiController extends BaseApiController
{
    protected ExecutionService $executionService;

    protected ExerciseService $exerciseService;

    protected WorkoutService $workoutService;

    public function __construct(EntityManagerInterface $entityManager, ExecutionService $executionService,
                                ExerciseService        $exerciseService, WorkoutService $workoutService)
    {
        parent::__construct($entityManager);
        $this->executionService = $executionService;
        $this->exerciseService = $exerciseService;
        $this->workoutService = $workoutService;
    }

    /**
     * @throws Exception
     */
    #[Route('/api/execution/create', name: 'create_execution_api', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);
        $exerciseName = $bodyParameters->exerciseName;
        $repetitions = $bodyParameters->repetitions;
        $weight = $bodyParameters->weight;
        // always use the latest workout (by id) => you need to create a workout first
        $workout = $this->workoutService->findLatest();
        $exercise = $this->exerciseService->showByUniqueName($exerciseName);
        $execution = $this->executionService->create($exercise, $workout, $repetitions, $weight);

        return $this->json($execution->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/execution/list', name: 'list_execution_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $executions = $this->executionService->list();
        $executionsArray = [];
        foreach ($executions as $execution) {
            $executionsArray[] = $execution->jsonSerialize();
        }
        return $this->json($executionsArray, Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/execution/update/{id}', name: 'update_execution_api', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);
        $newExerciseName = $bodyParameters->exerciseName;
        $newRepetitions = $bodyParameters->repetitions;
        $weight = $bodyParameters->weight;

        $exercise = $this->exerciseService->showByUniqueName($newExerciseName);
        $execution = $this->executionService->update($id, $exercise, $weight, $newRepetitions);
        return $this->json($execution->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/execution/show/{id}', name: 'show_execution_api', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $execution = $this->executionService->show($id);
        return $this->json($execution->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/execution/delete/{id}', name: 'delete_execution_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->executionService->delete($id);
        $shouldBeNull = $this->executionService->show($id);
        if (null !== $shouldBeNull) {
            return $this->json('Execution with id ' . $id . ' failed to get deleted.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json('Execution with id ' . $id . ' successfully deleted.', Response::HTTP_OK);
    }
}
