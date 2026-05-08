<?php

namespace App\DataFixtures;

use App\Entity\Execution;
use App\Entity\Exercise;
use App\Entity\Set;
use App\Entity\Workout;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExecutionFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadExecution($manager);
    }

    private function loadExecution(ObjectManager $manager): void
    {
        $exercise = $this->getReference('exercise', Exercise::class);

        $workout = $this->getReference('workout', Workout::class);

        $set = $this->getReference('set', Set::class);

        $execution = new Execution();
        $execution->setExercise($exercise);
        $execution->setWorkout($workout);
        $execution->setWeight(84);
        $execution->setAssociatedSet($set);
        $execution->buildIdentifier();

        $manager->persist($execution);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ExerciseFixtures::class,
            WorkoutFixtures::class,
            SetFixtures::class,
        ];
    }
}
