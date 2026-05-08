<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use App\Entity\Set;
use App\Entity\Workout;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->loadSet($manager);
    }

    private function loadSet(ObjectManager $manager): void
    {
        $set = new Set();
        $set->setRepetitions(12);

        $workout = $this->getReference('workout', Workout::class);
        $set->setWorkout($workout);

        $exercise = $this->getReference('exercise', Exercise::class);
        $set->setExercise($exercise);
        $set->buildIdentifier();

        $manager->persist($set);
        $manager->flush();

        $this->addReference('set', $set);
    }

    /**
     * @return list<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            WorkoutFixtures::class,
            ExerciseFixtures::class
        ];
    }

}
