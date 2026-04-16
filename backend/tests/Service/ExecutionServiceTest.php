<?php

namespace App\Tests\Service;

use App\Entity\Execution;
use App\Entity\Exercise;
use App\Entity\Set;
use App\Entity\Workout;
use App\Repository\ExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\SetRepository;
use App\Repository\WorkoutRepository;
use App\Service\ExecutionService;
use Doctrine\ORM\EntityManager;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class ExecutionServiceTest extends TestCase
{
    protected ManagerRegistry $managerRegistry;

    protected ?Execution $execution;

    protected ?MockObject $repoMock;

    protected ?ExecutionService $executionService;

    protected ?MockObject $workoutRepoMock;

    protected ?MockObject $exerciseRepoMock;

    protected ?MockObject $setRepoMock;

    /**
     * @throws Exception
     * @throws \ReflectionException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function setUp(): void
    {
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);

        $this->execution = new Execution();
        $reflection = new \ReflectionClass($this->execution);
        $property = $reflection->getProperty('id');
        $property->setValue($this->execution, 123);

        $exercise = new Exercise('unique name');
        $this->execution->setExercise($exercise);

        $this->repoMock = $this->getMockBuilder(ExecutionRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->workoutRepoMock = $this->getMockBuilder(WorkoutRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->exerciseRepoMock = $this->getMockBuilder(ExerciseRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->setRepoMock = $this->getMockBuilder(SetRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->executionService = new ExecutionService($this->repoMock);
    }

    public function tearDown(): void
    {
        $this->repoMock = null;
        $this->executionService = null;
    }

    public function testCreateExecution(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->execution);
        $repetitions = 10;
        $weight = 25;
        $setToAdd = new Set();
        $reflection = new \ReflectionClass($setToAdd);
        $property = $reflection->getProperty('id');
        $property->setValue($setToAdd, 123);

        $exerciseToAdd = new Exercise('unique name');
        $reflection = new \ReflectionClass($exerciseToAdd);
        $property = $reflection->getProperty('id');
        $property->setValue($exerciseToAdd, 123);

        $workoutToAdd = new Workout(true, 90);
        $reflection = new \ReflectionClass($workoutToAdd);
        $property = $reflection->getProperty('id');
        $property->setValue($workoutToAdd, 123);

        $this->setRepoMock->method('findOneBy')->willReturn($setToAdd);
        $this->exerciseRepoMock->method('findOneBy')->willReturn($exerciseToAdd);
        $this->workoutRepoMock->method('findBy')->willReturn([$workoutToAdd]);

        $createdExecution = $this->executionService->create($exerciseToAdd, $workoutToAdd, $setToAdd, $repetitions, $weight);

        $this->assertNotNull($createdExecution);
        $this->assertInstanceOf(Execution::class, $createdExecution);
        $this->assertEquals($exerciseToAdd, $createdExecution->getExercise());
        $this->assertEquals($workoutToAdd, $createdExecution->getWorkout());
        $this->assertEquals($setToAdd, $createdExecution->getAssociatedSet());
    }

    public function testBuildIdentifier(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->execution);
        $this->execution->setRepetitions(11);
        $this->execution->setWeight(80.0);

        $exerciseToAdd = new Exercise('unique name');
        $reflection = new \ReflectionClass($exerciseToAdd);
        $property = $reflection->getProperty('id');
        $property->setValue($exerciseToAdd, 123);

        $this->exerciseRepoMock->method('findOneBy')->willReturn($exerciseToAdd);

        $execution = $this->executionService->buildIdentifier($this->execution);

        $this->assertNotNull($execution);
        $this->assertNotEmpty($execution->getIdentifier());
        $this->assertInstanceOf(Execution::class, $execution);
        $this->assertTrue(str_contains($execution->getIdentifier(), 80.0));
        $this->assertTrue(str_contains($execution->getIdentifier(), 11));
    }

    /**
     * @throws \Exception
     */
    public function testUpdateExerciseExecution(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->execution);
        $this->repoMock->method('findBy')->willReturn([$this->execution]);

        $firstExercise = new Exercise('unique name 1');
        $firstExercise->addExecution($this->execution);
        $reflection = new \ReflectionClass($firstExercise);
        $property = $reflection->getProperty('id');
        $property->setValue($firstExercise, 123);

        $secondExercise = new Exercise('unique name 2');
        $reflection = new \ReflectionClass($secondExercise);
        $property = $reflection->getProperty('id');
        $property->setValue($secondExercise, 124);

        $updatedExecution = $this->executionService->update($this->execution->getId(), $secondExercise);
        $this->assertNotNull($updatedExecution);
        $this->assertEquals('unique name 2', $updatedExecution->getExercise()->getUniqueName());
    }

    /**
     * @throws \Exception
     */
    public function testUpdateWeightExecution(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->execution);
        $this->repoMock->method('findBy')->willReturn([$this->execution]);

        $weight = 24;
        $execution = $this->execution;
        $updatedExecution = $this->executionService->update($execution->getId(), null, $weight);
        $this->assertNotNull($execution);
        $this->assertEquals($weight, $updatedExecution->getWeight());
    }

    /**
     * @throws \Exception
     */
    public function testUpdateRepetitionsExecution(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->execution);
        $this->repoMock->method('findBy')->willReturn([$this->execution]);

        $repetitions = 84;
        $createdExecution = $this->execution;
        $updatedExecution = $this->executionService->update($createdExecution->getId(), null, null, $repetitions);
        $this->assertNotNull($updatedExecution);
        $this->assertEquals($repetitions, $updatedExecution->getRepetitions());
    }
}
