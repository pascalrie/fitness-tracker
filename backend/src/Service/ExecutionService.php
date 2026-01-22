<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Entity\Execution;
use App\Entity\Workout;
use App\Repository\ExecutionRepository;
use Doctrine\ORM\EntityNotFoundException;

class ExecutionService
{
    protected ExecutionRepository $executionRepository;

    public function __construct(ExecutionRepository $executionRepository)
    {
        $this->executionRepository = $executionRepository;
    }

    public function create(Exercise $exercise, Workout $workout, int $repetitions = 12, float $weight = 0): Execution
    {
        $execution = new Execution($exercise, $weight, $repetitions, $workout);
        $this->executionRepository->add($execution, true);
        return $execution;
    }

    /**
     * @throws \Exception
     */
    public function update(int $id, ?Exercise $exercise = null, float $weight = 0, ?int $repetitions = null): Execution
    {
        $execution = $this->show($id);
        if (!$execution) {
            throw new EntityNotFoundException('Execution with id ' . $id . ' not found');
        }
        if ($exercise) {
            $execution->setExercise($exercise);
        }
        if ($weight) {
            $execution->setWeight($weight);
        }
        if ($repetitions) {
            $execution->setRepetitions($repetitions);
        }
        $this->executionRepository->flush();

        return $execution;
    }

    public function delete(int $id): void
    {
        $execution = $this->show($id);
        if (!$execution) {
            throw new EntityNotFoundException('Execution with id ' . $id . ' not found for deletion.');
        }
        $this->executionRepository->remove($execution, true);
    }

    public function show(int $id): ?Execution
    {
        return $this->executionRepository->findBy(['id' => $id])[0];
    }

    public function list(): array
    {
        return $this->executionRepository->findAll();
    }

    public function showBy(string $identifier, int $value): array
    {
        return $this->executionRepository->findBy([$identifier => $value]);
    }
}
