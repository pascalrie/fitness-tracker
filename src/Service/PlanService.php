<?php

namespace App\Service;

use App\Entity\Plan;
use App\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;

class PlanService
{
    protected PlanRepository $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function create(?int $totalDaysOfTraining = null, ?int $trainingTimesAWeek = null, ?int $split = null): Plan
    {
        $plan = new Plan($totalDaysOfTraining, $trainingTimesAWeek, $split);
        $this->planRepository->add($plan);
        return $plan;
    }

    public function update(int  $id, ?int $newTotalDaysOfTraining = null, ?int $newTrainingTimesAWeek = null,
                           ?int $newSplit = null, array $newExercises = null): Plan
    {
        $plan = $this->show($id);
        if (null !== $newTotalDaysOfTraining) {
            $plan->setTotalDaysOfTraining($newTotalDaysOfTraining);
        }

        if (null !== $newTrainingTimesAWeek) {
            $plan->setTrainingTimesAWeek($newTrainingTimesAWeek);
        }

        if (null !== $newSplit) {
            $plan->setSplit($newSplit);
        }

        if (null !== $newExercises) {
            foreach ($newExercises as $newExercise) {
                $plan->addExercise($newExercise);
            }
        }

        $plan->setUpdatedAt(new \DateTime('NOW'));
        $this->planRepository->flush();

        return $plan;
    }

    public function delete(int $id): void
    {
        $plan = $this->show($id);
        $this->planRepository->remove($plan);
    }

    public function show(int $id): ?Plan
    {
        return $this->planRepository->findOneBy(['id' => $id]);
    }

    public function list(): array
    {
        return $this->planRepository->findAll();
    }
}
