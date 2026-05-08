<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadExercise($manager);
    }

    private function loadExercise(ObjectManager $manager): void
    {
        $exercise = new Exercise();
        $exercise->setUniqueName("Unique Exercise name");

        $manager->persist($exercise);
        $manager->flush();

        $this->addReference('exercise', $exercise);
    }
}
