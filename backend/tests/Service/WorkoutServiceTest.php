<?php

namespace App\Tests\Service;

use App\Entity\BodyMeasurement;
use App\Entity\Workout;
use App\Repository\BodyMeasurementRepository;
use App\Repository\WorkoutRepository;
use App\Service\BodyMeasurementService;
use App\Service\WorkoutService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class WorkoutServiceTest extends TestCase
{
    protected ManagerRegistry $managerRegistry;

    protected ?Workout $workout;

    protected ?BodyMeasurement $bodyMeasurement;

    protected ?MockObject $repoMock;

    protected ?WorkoutService $workoutService;

    protected ?BodyMeasurementService $bodyMeasurementService;

    protected ?MockObject $exerciseRepoMock;

    protected ?MockObject $bodyMeasurementMock;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->bodyMeasurement = new BodyMeasurement(76.0);

        $this->workout = new Workout();
        $reflection = new \ReflectionClass(Workout::class);
        $property = $reflection->getProperty('id');
        $property->setValue($this->workout, 123);

        $this->repoMock = $this->getMockBuilder(WorkoutRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->bodyMeasurementMock = $this->getMockBuilder(BodyMeasurementRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->bodyMeasurementService = new BodyMeasurementService($this->bodyMeasurementMock);
        $this->workoutService = new WorkoutService($this->repoMock, $this->bodyMeasurementService);
    }

    public function tearDown(): void
    {
        $this->repoMock = null;
        $this->workout = null;
        $this->bodyMeasurementService = null;
        $this->workoutService = null;
    }

    public function testCreateWorkout()
    {
        $this->repoMock->method('findOneBy')->willReturn($this->workout);
        $this->repoMock->method('findBy')->willReturn([$this->workout]);
        $this->bodyMeasurementMock->method('findOneBy')->willReturn($this->bodyMeasurement);

        $workout = $this->workoutService->create();
        $this->assertInstanceOf(Workout::class, $workout);
    }

    public function testUpdateStretchWorkout(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->workout);
        $this->repoMock->method('findBy')->willReturn([$this->workout]);
        $this->bodyMeasurementMock->method('findOneBy')->willReturn($this->bodyMeasurement);

        $workout = $this->workoutService->update($this->workout->getId(), true);

        $this->assertInstanceOf(Workout::class, $workout);
        $this->assertEquals($this->workout, $workout);

    }

    public function testUpdateBodyWeightWorkout(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->workout);
        $this->repoMock->method('findBy')->willReturn([$this->workout]);
        $this->bodyMeasurementMock->method('findOneBy')->willReturn($this->bodyMeasurement);
        $this->workout->setBodyWeight(90);
        $newBodyWeight = 85.5;
        $workout = $this->workoutService->update($this->workout->getId(), null, $newBodyWeight);

        $this->assertInstanceOf(Workout::class, $workout);
        $this->assertEquals($this->workout, $workout);
        $this->assertEquals($newBodyWeight, $this->workout->getBodyWeight());
    }

    public function testBuildIdentifierWorkout(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->workout);
        $this->repoMock->method('findBy')->willReturn([$this->workout]);
        $this->bodyMeasurementMock->method('findOneBy')->willReturn($this->bodyMeasurement);

        $currentDate = (new \DateTime('NOW'))->format('d-m-Y');
        $workout = $this->workoutService->buildIdentifier($this->workout);
        $this->assertInstanceOf(Workout::class, $workout);
        $this->assertEquals($currentDate, $workout->getIdentifier());
    }
}
