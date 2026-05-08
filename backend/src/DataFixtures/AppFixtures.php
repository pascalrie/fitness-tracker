<?php

namespace App\DataFixtures;

use App\Entity\BodyMeasurement;
use App\Entity\MuscleGroup;
use App\Entity\Plan;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadBodyMeasurement($manager);
        $this->loadMuscleGroup($manager);
        $this->loadPlan($manager);
    }

    private function loadBodyMeasurement(ObjectManager $manager): void
    {
        $bodyMeasurement = new BodyMeasurement();
        $bodyMeasurement->setBodyHeight(1.82);
        $bodyMeasurement->setBodyWeight(84);
        $bodyMeasurement->setBmi(round(84 / (pow(1.82, 2)), 3));
        $bodyMeasurement->setFitnessEvaluation(82);
        $bodyMeasurement->buildIdentifier();

        $manager->persist($bodyMeasurement);
        $manager->flush();
    }

    private function loadMuscleGroup(ObjectManager $manager): void
    {
        $muscleGroup = new MuscleGroup();
        $muscleGroup->setName("Beispielmuskelgruppe");

        $manager->persist($muscleGroup);
        $manager->flush();
    }

    private function loadPlan(ObjectManager $manager): void
    {
        $plan = new Plan();
        $plan->setActive(true);
        $plan->setSplit(2);
        $plan->setStartDate(new \DateTime('NOW'));
        $plan->setTotalDaysOfTraining(25);
        $plan->setTrainingTimesAWeek(3);
        $plan->buildIdentifier();

        $manager->persist($plan);
        $manager->flush();
    }
}
