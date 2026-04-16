<?php

namespace App\Tests\Service;

use App\Entity\Execution;
use App\Entity\Exercise;
use App\Entity\Set;
use App\Entity\Workout;
use App\Repository\ExerciseRepository;
use App\Repository\SetRepository;
use App\Repository\WorkoutRepository;
use App\Service\SetService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class SetServiceTest extends TestCase
{
    protected ManagerRegistry $managerRegistry;

    protected ?Set $set;

    protected ?MockObject $repoMock;

    protected ?SetService $setService;

    protected ?MockObject $exerciseRepoMock;

    protected ?MockObject $workoutRepoMock;

    /**
     * @throws Exception
     * @throws \ReflectionException
     */
    protected function setUp(): void
    {
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->set = new Set();
        $reflection = new ReflectionClass($this->set);
        $property = $reflection->getProperty('id');
        $property->setValue($this->set, 1234);

        $workout = new Workout();
        $this->set->setWorkout($workout);

        $exercise = new Exercise('unique name');
        $this->set->setExercise($exercise);

        $this->repoMock = $this->getMockBuilder(SetRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->exerciseRepoMock = $this->getMockBuilder(ExerciseRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->exerciseRepoMock = $this->getMockBuilder(WorkoutRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->setService = new SetService($this->repoMock);
    }

    public function tearDown(): void
    {
        $this->repoMock = null;
        $this->setService = null;
        $this->set = null;
    }

    public function testCreateSet(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->set);
        $this->repoMock->method('findBy')->willReturn([$this->set]);

        $exercise = new Exercise('unique name');
        $workout = new Workout(false, 85);

        $set = $this->setService->create($exercise, $workout);
        $this->assertInstanceOf(Set::class, $set);
        $this->assertEquals($exercise, $set->getExercise());
        $this->assertEquals($workout, $set->getWorkout());
    }

    public function testUpdateExerciseSet(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->set);
        $this->repoMock->method('findBy')->willReturn([$this->set]);

        $exercise = new Exercise('unique name');
        $set = $this->setService->update($this->set->getId(), $exercise);

        $this->assertInstanceOf(Set::class, $set);
        $this->assertEquals($exercise, $set->getExercise());
        $this->assertEquals($set, $this->set);
    }

    public function testUpdateExecutionSet(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->set);
        $this->repoMock->method('findBy')->willReturn([$this->set]);

        $execution = new Execution();

        $set = $this->setService->update($this->set->getId(), null, $execution);

        $this->assertInstanceOf(Set::class, $set);
        $this->assertEquals($execution, $set->getExecutions()[0]);
        $this->assertEquals($set, $this->set);
    }

    public function testUpdateRepetitionsSet(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->set);
        $this->repoMock->method('findBy')->willReturn([$this->set]);

        $repetitions = 15;

        $set = $this->setService->update($this->set->getId(), null, null, $repetitions);
        $this->assertInstanceOf(Set::class, $set);
        $this->assertEquals($repetitions, $set->getRepetitions());
        $this->assertEquals($set, $this->set);
    }

    public function testUpdateWorkoutSet(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->set);
        $this->repoMock->method('findBy')->willReturn([$this->set]);

        $workout = new Workout();
        $set = $this->setService->update($this->set->getId(), null, null, 0, $workout);
        $this->assertInstanceOf(Set::class, $set);
        $this->assertEquals($workout, $set->getWorkout());
        $this->assertEquals($set, $this->set);
    }
}
