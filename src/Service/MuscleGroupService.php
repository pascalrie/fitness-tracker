<?php

namespace App\Service;

use App\Entity\MuscleGroup;
use App\Repository\MuscleGroupRepository;

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
        $this->muscleGroupRepository->add($muscleGroup);
        return $muscleGroup;
    }

    public function update(int $id, ?string $newName = null): MuscleGroup
    {
        $muscleGroup = $this->show($id);

        if (null !== $newName) {
            $muscleGroup->setName($newName);
        }
        $this->muscleGroupRepository->flush();

        return $muscleGroup;
    }

    public function delete(int $id): void
    {
        $muscleGroup = $this->show($id);
        $this->muscleGroupRepository->remove($muscleGroup);
    }

    public function show(int $id): ?MuscleGroup
    {
        return $this->muscleGroupRepository->findOneBy(['id' => $id]);
    }

    public function list(): array
    {
        return $this->muscleGroupRepository->findAll();
    }
}
