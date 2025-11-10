<?php

namespace App\Controller;

use App\Service\ExerciseService;
use App\Service\PlanService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlanApiController extends BaseApiController
{
    protected PlanService $planService;

    protected ExerciseService $exerciseService;

    public function __construct(EntityManagerInterface $entityManager, PlanService $planService, ExerciseService $exerciseService)
    {
        parent::__construct($entityManager);

        $this->planService = $planService;
        $this->exerciseService = $exerciseService;
    }

    #[Route('/api/plan/create', name: 'create_plan_api', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $bodyParameters = json_decode($request->getContent());
        $totalDaysOfTraining = (int) $bodyParameters->totalDaysOfTraining;
        $trainingTimesAWeek = (int) $bodyParameters->trainingTimesAWeek;
        $split = (int) $bodyParameters->split;

        $plan = $this->planService->create($totalDaysOfTraining, $trainingTimesAWeek, $split);

        return $this->json($plan->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/plan/list', name: 'list_plan_api', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $plans = $this->planService->list();
        $plansArray = [];
        foreach ($plans as $plan) {
            $plansArray[] = $plan->jsonSerialize();
        }
        return $this->json($plansArray, Response::HTTP_OK);
    }

    #[Route('/api/plan/show/{id}', name: 'show_plan_api', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $plan = $this->planService->show($id);
        return $this->json($plan->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * @throws Exception
     */
    #[Route('/api/plan/update/{id}', name: 'update_plan_api', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $bodyParameters = $this->getBodyParameters($request);
        $newExercises = $bodyParameters->exercises;
        $newTotalDaysOfTraining = $bodyParameters->totalDaysOfTraining;
        $newTrainingTimesAWeek = $bodyParameters->trainingTimesAWeek;
        $newSplit = $bodyParameters->split;

        $exercises = [];
        foreach ($newExercises as $exercise) {
            $exercises[] = $this->exerciseService->showByUniqueName($exercise);
        }

        $newPlan = $this->planService->update($id, $newTotalDaysOfTraining, $newTrainingTimesAWeek, $newSplit, $exercises);
        return $this->json($newPlan->jsonSerialize(), Response::HTTP_OK);
    }

    #[Route('/api/plan/delete/{id}', name: 'delete_plan_api', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->planService->delete($id);
        $shouldBeNull = $this->planService->show($id);

        if (null !== $shouldBeNull) {
            return $this->json('Deletion of Plan with id: ' . $id . ' failed.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json('Deletion was successful.', Response::HTTP_OK);
    }
}
