<?php

namespace App\Service;

use App\Entity\Execution;
use App\Entity\Exercise;
use App\Entity\Set;
use App\Entity\Workout;
use App\Repository\SetRepository;
use Doctrine\ORM\EntityNotFoundException;

class SetService
{
    protected SetRepository $setRepository;

    public function __construct(SetRepository $setRepository)
    {
        $this->setRepository = $setRepository;
    }

    public function create(Exercise $exercise, Workout $workout, ?int $repetitions = null): Set
    {
        $set = new Set();

        $set->setExercise($exercise);
        $set->setWorkout($workout);
        $set->buildIdentifier();

        if ($repetitions !== null) {
            $set->setRepetitions($repetitions);
        }

        $this->setRepository->add($set, true);
        return $set;
    }

    public function update(int $setId, ?Exercise $exercise = null, ?Execution $addExecution = null, ?int $repetitions = 0, ?Workout $workout = null): Set
    {
        $set = $this->show($setId);
        $set->setUpdatedAt(new \DateTime('NOW'));

        if ($exercise !== null) {
            $set->setExercise($exercise);
        }

        if ($addExecution !== null) {
            $set->addExecution($addExecution);
        }

        if ($repetitions !== 0) {
            $set->setRepetitions($repetitions);
        }

        if ($workout !== null) {
            $set->setWorkout($workout);
        }

        $set->buildIdentifier();

        $this->setRepository->flush();

        return $set;
    }

    public function delete(int $setId): void
    {
        $set = $this->show($setId);
        if (!$set) {
            throw new EntityNotFoundException('Set with id ' . $setId . ' not found for deletion.');
        }
        $this->setRepository->remove($set, true);
    }

    public function show(int $setId): ?Set
    {
        return $this->setRepository->findBy(['id' => $setId])[0];
    }

    public function list(): array
    {
        return $this->setRepository->findAll();
    }
}
