<?php

namespace App\Controller;

use App\Service\ExecutionService;
use App\Service\ExerciseService;
use App\Service\MuscleGroupService;
use App\Service\PlanService;
use App\Service\WorkoutService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ExerciseApiController extends BaseApiController
{
    protected ExerciseService $exerciseService;

    protected ExecutionService $executionService;

    protected PlanService $planService;

    protected WorkoutService $workoutService;

    protected MuscleGroupService $muscleGroupService;

    public function __construct(EntityManagerInterface $entityManager, ExerciseService $exerciseService, ExecutionService $executionService,
                                PlanService $planService, WorkoutService $workoutService, MuscleGroupService $muscleGroupService)
    {
        parent::__construct($entityManager);
        $this->exerciseService = $exerciseService;
        $this->executionService = $executionService;
        $this->planService = $planService;
        $this->workoutService = $workoutService;
        $this->muscleGroupService = $muscleGroupService;
    }

    /**
     * @throws \Exception
     */
    #[Route('/exercise/api/create', name: 'create_exercise_api', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);
        $uniqueName = $bodyParameters->uniqueName;

        $exercise = $this->exerciseService->create($uniqueName);

        return $this->json($exercise->jsonSerialize(false), Response::HTTP_OK);
    }

    #[Route('/exercise/api/list', name: 'list_exercise_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $exercises = $this->exerciseService->list();
        $list = [];
        foreach ($exercises as $exercise) {
            $list[] = $exercise->jsonSerialize();
        }
        return $this->json($list, Response::HTTP_OK);
    }

    #[Route('/exercise/api/show/{id}', name: 'show_exercise_api', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $exercise = $this->exerciseService->show($id);
        return $this->json($exercise->jsonSerialize(true, true, true), Response::HTTP_OK);
    }

    #[Route('/exercise/api/update/{id}', name: 'update_exercise_api', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);

        $uniqueName = $bodyParameters->uniqueName;
        $executionIds = $bodyParameters->executionId;
        $planIds = $bodyParameters->planIds;
        $workoutIds = $bodyParameters->workoutIds;
        $muscleGroupIds = $bodyParameters->muscleGroupIds;

        $executions = $this->getExecutionObjectsFromIds($executionIds);
        $plans = $this->getPlanObjectsFromIds($planIds);
        $workouts = $this->getWorkoutObjectsFromIds($workoutIds);
        $muscleGroups = $this->getMuscleGroupObjectsFromIds($muscleGroupIds);

        $exercise = $this->exerciseService->update($id, $uniqueName, $executions, $plans, $workouts, $muscleGroups);
        return $this->json($exercise->jsonSerialize(true, true, true), Response::HTTP_OK);
    }

    #[Route('/exercise/api/delete/{id}', name: 'delete_exercise_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->exerciseService->delete($id);
        $shouldBeNull = $this->exerciseService->show($id);
        if (null !== $shouldBeNull) {
            return $this->json("Deletion of Exercise with id: " . $id . " failed.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json("Deletion of Exercise with id: " . $id . " completed.", Response::HTTP_OK);
    }

    private function getExecutionObjectsFromIds(array $ids): array
    {
        $executions = [];
        foreach ($ids as $executionId) {
            $executions[] = $this->executionService->show($executionId);
        }
        return $executions;
    }

    private function getPlanObjectsFromIds(array $ids): array
    {
        $plans = [];
        foreach ($ids as $planId) {
            $plans[] = $this->planService->show($planId);
        }
        return $plans;
    }

    private function getWorkoutObjectsFromIds(array $ids): array
    {
        $workouts = [];
        foreach ($ids as $workoutId) {
            $workouts[] = $this->workoutService->show($workoutId);
        }
        return $workouts;
    }

    private function getMuscleGroupObjectsFromIds(array $ids): array
    {
        $muscleGroups = [];
        foreach ($ids as $muscleGroupId) {
            $muscleGroups[] = $this->muscleGroupService->show($muscleGroupId);
        }
        return $muscleGroups;
    }
}
