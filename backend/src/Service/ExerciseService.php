<?php

namespace App\Service;

use App\Entity\Execution;
use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityNotFoundException;
use Exception;

class ExerciseService
{
    protected ExerciseRepository $exerciseRepository;

    public function __construct(ExerciseRepository $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    /**
     * @throws Exception
     */
    public function create(string $uniqueName): Exercise
    {
        $exercise = new Exercise($uniqueName);
        $this->exerciseRepository->add($exercise, true);
        return $exercise;
    }

    public function update(int   $id, string $newUniqueName = null, array $executions = [], array $plans = [],
                           array $workouts = [], array $muscleGroups = []): Exercise
    {
        $exercise = $this->show($id);
        if (!$exercise) {
            throw new EntityNotFoundException('Exercise with id ' . $id . ' not found');
        }
        if (null !== $newUniqueName) {
            $exercise->setUniqueName($newUniqueName);
        }
        if (null !== $executions) {
            foreach ($executions as $execution) {
                $exercise->addExecution($execution);
            }
        }
        if (null !== $plans) {
            foreach ($plans as $plan) {
                $exercise->addPlan($plan);
            }
        }
        if (null !== $workouts) {
            foreach ($workouts as $workout) {
                $exercise->addWorkout($workout);
            }
        }
        if (null !== $muscleGroups) {
            foreach ($muscleGroups as $muscleGroup) {
                $exercise->addMuscleGroup($muscleGroup);
            }
        }

        $this->exerciseRepository->flush();
        return $exercise;
    }

    public function delete(int $id): void
    {
        $exercise = $this->show($id);
        if (!$exercise) {
            throw new EntityNotFoundException('Exercise with id ' . $id . ' not found for deletion.');
        }
        $this->exerciseRepository->remove($exercise, true);
    }

    public function show(int $id): ?Exercise
    {
        return $this->exerciseRepository->findBy(['id' => $id])[0];
    }

    public function list(): array
    {
        return $this->exerciseRepository->findAll();
    }

    /**
     * @throws Exception
     */
    public function showByUniqueName(string $uniqueName): ?Exercise
    {
        if (count($this->exerciseRepository->findBy(['uniqueName' => $uniqueName])) > 1) {
            throw new Exception('Unique name of exercise exists multiple times. Please check that.');
        }

        return $this->exerciseRepository->findBy(['uniqueName' => $uniqueName])[0];
    }
}
