<?php

namespace App\Tests\Service;

use App\Entity\Exercise;
use App\Entity\Plan;
use App\Repository\ExerciseRepository;
use App\Repository\PlanRepository;
use App\Service\PlanService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class PlanServiceTest extends TestCase
{
    protected ManagerRegistry $managerRegistry;

    protected ?Plan $plan;

    protected ?MockObject $repoMock;

    protected ?PlanService $planService;

    protected ?MockObject $exerciseRepoMock;

    /**
     * @throws \ReflectionException
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->plan = new Plan();
        $this->plan->setTotalDaysOfTraining(38);
        $this->plan->setSplit(3);
        $this->plan->setTrainingTimesAWeek(4);
        $this->plan->setActive(false);
        $reflection = new ReflectionClass($this->plan);
        $property = $reflection->getProperty('id');
        $property->setValue($this->plan, 123);

        $this->repoMock = $this->getMockBuilder(PlanRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->exerciseRepoMock = $this->getMockBuilder(ExerciseRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->planService = new PlanService($this->repoMock);
    }

    public function tearDown(): void
    {
        $this->repoMock = null;
        $this->planService = null;
        $this->plan = null;
    }

    public function testCreatePlan(): void
    {
        $totalDaysOfTraining = 40;
        $trainingTimesAWeek = 5;
        $split = 2;
        $plan = $this->planService->create($totalDaysOfTraining, $trainingTimesAWeek, $split);
        $this->assertInstanceOf(Plan::class, $plan);
        $this->assertEquals($totalDaysOfTraining, $plan->getTotalDaysOfTraining());
        $this->assertEquals($trainingTimesAWeek, $plan->getTrainingTimesAWeek());
        $this->assertEquals($split, $plan->getSplit());
    }

    public function testUpdateTotalDaysOfTrainingPlan(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->plan);
        $this->repoMock->method('findBy')->willReturn([$this->plan]);

        $this->plan = $this->planService->update($this->plan->getId(), false, 42);
        $this->assertInstanceOf(Plan::class, $this->plan);
        $this->assertEquals(42, $this->plan->getTotalDaysOfTraining());
    }

    public function testUpdateTrainingTimesAWeekPlan(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->plan);
        $this->repoMock->method('findBy')->willReturn([$this->plan]);

        $this->plan = $this->planService->update($this->plan->getId(), false, null, 6);
        $this->assertInstanceOf(Plan::class, $this->plan);
        $this->assertEquals(6, $this->plan->getTrainingTimesAWeek());
    }

    public function testUpdateSplitPlan(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->plan);
        $this->repoMock->method('findBy')->willReturn([$this->plan]);

        $this->plan = $this->planService->update($this->plan->getId(), false, null, null, 4);
        $this->assertInstanceOf(Plan::class, $this->plan);
        $this->assertEquals(4, $this->plan->getSplit());
    }

    public function testUpdateExercisePlan(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->plan);
        $this->repoMock->method('findBy')->willReturn([$this->plan]);
        $exercise = new Exercise('unique name 4');

        $this->plan = $this->planService->update($this->plan->getId(), false, null, null, null, [$exercise]);
        $this->assertInstanceOf(Plan::class, $this->plan);
        $this->assertEquals($exercise, $this->plan->getExercises()[0]);
    }
}
