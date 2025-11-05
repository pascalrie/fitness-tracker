<?php

namespace App\Service;

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
        $mustBeNull = $this->showByUniqueName($uniqueName);
        if (null !== $mustBeNull) {
            throw new Exception('Unique name ' . $uniqueName . ' cannot be given more than once.');
        }
        $exercise = new Exercise($uniqueName);
        $this->exerciseRepository->add($exercise);
    }

    public function update(int $id): Exercise
    {
        $exercise = $this->show($id);
        if (!$exercise) {
            throw new EntityNotFoundException('Exercise with id ' . $id . ' not found');
        }

        return $exercise;
    }

    public function delete()
    {

    }

    public function show()
    {

    }

    public function list()
    {

    }

    /**
     * @throws Exception
     */
    public function showByUniqueName(string $uniqueName): Exercise
    {
        if (count($this->exerciseRepository->findBy(['uniqueName' => $uniqueName])) > 0) {
            throw new Exception('Unique name of exercise exists multiple times. Please check that.');
        }

        return $this->exerciseRepository->findBy(['uniqueName' => $uniqueName])[0];
    }
}
