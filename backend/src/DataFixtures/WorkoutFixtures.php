<?php

namespace App\DataFixtures;

use App\Entity\Workout;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WorkoutFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadWorkout($manager);
    }

    private function loadWorkout(ObjectManager $manager): void
    {
        $workout = new Workout();
        $workout->setBodyWeight(82);
        $workout->setDateOfWorkout(new \DateTime('NOW'));
        $workout->setStretch(true);
        $workout->buildIdentifier();

        $manager->persist($workout);
        $manager->flush();

        $this->addReference('workout', $workout);
    }
}
