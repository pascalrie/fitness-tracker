<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Entity\MuscleGroup;
use App\Repository\MuscleGroupRepository;
use Doctrine\ORM\EntityNotFoundException;
use Exception;

class MuscleGroupService
{
    protected MuscleGroupRepository $muscleGroupRepository;

    public function __construct(MuscleGroupRepository $muscleGroupRepository)
    {
        $this->muscleGroupRepository = $muscleGroupRepository;
    }

    public function create(string $name): MuscleGroup
    {
        $muscleGroup = new MuscleGroup($name);
        $this->muscleGroupRepository->add($muscleGroup, true);
        return $muscleGroup;
    }

    /**
     * @throws Exception
     */
    public function update(int $id, ?string $newName = null, ?array $newExercises = []): MuscleGroup
    {
        $muscleGroup = $this->show($id);
        if (!$muscleGroup) {
            throw new EntityNotFoundException('MuscleGroup with id ' . $id . ' not found');
        }
        if (null !== $newName) {
            if ($this->showByUniqueName($newName) !== null) {
                throw new Exception('MuscleGroup with name ' . $newName . ' already exists');
            }
            $muscleGroup->setName($newName);
        }
        if (null !== $newExercises) {
            foreach ($newExercises as $newExercise) {
                $muscleGroup->addExercise($newExercise);
            }
        }

        $this->muscleGroupRepository->flush();

        return $muscleGroup;
    }

    public function delete(int $id): void
    {
        $muscleGroup = $this->show($id);
        if (!$muscleGroup) {
            throw new EntityNotFoundException('Muscle Group with id ' . $id . ' not found for deletion.');
        }
        $this->muscleGroupRepository->remove($muscleGroup, true);
    }

    public function show(int $id): ?MuscleGroup
    {
        return $this->muscleGroupRepository->findBy(['id' => $id])[0];
    }

    public function list(): array
    {
        return $this->muscleGroupRepository->findAll();
    }

    /**
     * @throws Exception
     */
    public function showByUniqueName(string $name): ?MuscleGroup
    {
        if (count($this->muscleGroupRepository->findBy(['uniqueName' => $name])) > 1) {
            throw new Exception('Unique name of muscle group exists multiple times. Please check that.');
        }

        return $this->muscleGroupRepository->findBy(['uniqueName' => $name])[0];
    }
}
