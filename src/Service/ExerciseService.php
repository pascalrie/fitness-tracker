<?php

namespace App\Service;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use Exception;

class ExerciseService
{
    protected ExerciseRepository $exerciseRepository;

    public function __construct(ExerciseRepository $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    public function create()
    {

    }

    public function update()
    {

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
            throw new Exception('Unique name exists multiple times. Please check that.');
        }

        return $this->exerciseRepository->findBy(['uniqueName' => $uniqueName])[0];
    }
}
