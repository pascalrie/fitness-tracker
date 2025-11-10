<?php

namespace App\Service;

use App\Entity\Workout;
use App\Repository\WorkoutRepository;
use Doctrine\ORM\EntityNotFoundException;

class WorkoutService
{
    protected WorkoutRepository $workoutRepository;

    protected BodyMeasurementService $bodyMeasurementService;

    public function __construct(WorkoutRepository $workoutRepository, BodyMeasurementService $bodyMeasurementService)
    {
        $this->workoutRepository = $workoutRepository;
        $this->bodyMeasurementService = $bodyMeasurementService;
    }

    public function create(?bool $stretch = null, ?float $bodyWeight = null): Workout
    {
        $workout = new Workout($stretch, $bodyWeight);
        $this->workoutRepository->add($workout, true);
        return $workout;
    }

    public function update(int $id, ?bool $stretch = null, ?float $bodyWeight = null): Workout
    {
        $workout = $this->show($id);
        if (!$workout) {
            throw new EntityNotFoundException('Workout with id ' . $id . ' not found');
        }
        if (null !== $stretch) {
            $workout->setStretch($stretch);
        }

        if (null === $bodyWeight) {
            // sets the bodyweight according to the latest Body measurement if none is explicitly given
            $latest = $this->bodyMeasurementService->getLatest()->getBodyWeight();
            if (null !== $latest) {
                $bodyWeight = $latest;
            }
        }
        $workout->setBodyWeight($bodyWeight);

        $this->workoutRepository->flush();

        return $workout;
    }

    public function delete(int $id): void
    {
        $workout = $this->workoutRepository->findBy(['id' => $id])[0];
        if (!$workout) {
            throw new EntityNotFoundException('Workout with id ' . $id . ' not found for deletion.');
        }
        $this->workoutRepository->remove($workout, true);
    }

    public function show(int $id): ?Workout
    {
        return $this->workoutRepository->findBy(['id' => $id])[0];
    }

    public function list(): array
    {
        return $this->workoutRepository->findAll();
    }

    public function findLatest(): Workout
    {
        return $this->workoutRepository->findOneBy([], ['id' => 'DESC']);
    }
}
