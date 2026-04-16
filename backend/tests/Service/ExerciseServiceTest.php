<?php

namespace App\Tests\Service;

use App\Entity\Execution;
use App\Entity\Exercise;
use App\Entity\MuscleGroup;
use App\Entity\Plan;
use App\Entity\Set;
use App\Entity\Workout;
use App\Repository\ExecutionRepository;
use App\Repository\ExerciseRepository;
use App\Repository\PlanRepository;
use App\Repository\SetRepository;
use App\Repository\WorkoutRepository;
use App\Service\ExerciseService;
use Doctrine\ORM\EntityManager;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class ExerciseServiceTest extends TestCase
{
    protected ManagerRegistry $managerRegistry;

    protected ?Exercise $exercise;

    protected ?MockObject $repoMock;

    protected ?ExerciseService $exerciseService;

    protected ?MockObject $workoutRepoMock;

    protected ?MockObject $executionRepoMock;

    protected ?MockObject $planRepoMock;

    protected ?MockObject $setRepoMock;

    /**
     * @throws Exception
     * @throws \ReflectionException
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function setUp(): void
    {
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);

        $this->exercise = new Exercise();
        $reflection = new \ReflectionClass($this->exercise);
        $property = $reflection->getProperty('id');
        $property->setValue($this->exercise, 123);

        $this->repoMock = $this->getMockBuilder(ExerciseRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->workoutRepoMock = $this->getMockBuilder(WorkoutRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->planRepoMock = $this->getMockBuilder(PlanRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->executionRepoMock = $this->getMockBuilder(ExecutionRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->setRepoMock = $this->getMockBuilder(SetRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->exerciseService = new ExerciseService($this->repoMock);
    }

    public function tearDown(): void
    {
        $this->repoMock = null;
        $this->exerciseService = null;
        $this->exercise = null;
    }

    /**
     * @throws Exception
     */
    public function testCreateExercise(): void
    {
        $uniqueName = 'exercise 1';
        $this->repoMock->method('findOneBy')->willReturn($this->exercise);
        $exercise = $this->exerciseService->create($uniqueName);

        $this->assertNotNull($this->exercise);
        $this->assertEquals($uniqueName, $exercise->getUniqueName());
    }
/** not testable due to mocking
    public function testUpdateExerciseUniqueName(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->exercise);
        $this->repoMock->method('findBy')->willReturn([$this->exercise]);
        $exercise = $this->exerciseService->create('unique name 1');
        $reflection = new \ReflectionClass($exercise);
        $property = $reflection->getProperty('id');
        $property->setValue($exercise, 124);

        $updatedExercise = $this->exerciseService->update($exercise->getId(), 'unique name 4');
        $this->assertNotNull($updatedExercise);
        $this->assertEquals('unique name 4', $updatedExercise->getUniqueName());
    }
*/
    /**
     * @throws \Exception
     */
    public function testUpdateExecutionsExercise(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->exercise);
        $this->repoMock->method('findBy')->willReturn([$this->exercise]);

        $set = new Set();
        $exercise = $this->exercise;

        $workout = new Workout();
        $execution = new Execution($exercise, $set, 5, 12, $workout);
        $updatedExercise = $this->exerciseService->update($exercise->getId(), null, [$execution]);
        $this->assertNotNull($exercise);
        $this->assertCount(1, $updatedExercise->getExecutions());
        $this->assertEquals($execution, $updatedExercise->getExecutions()[0]);
    }

    /**
     * @throws \Exception
     */
    public function testUpdatePlansExercise(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->exercise);
        $this->repoMock->method('findBy')->willReturn([$this->exercise]);

        $plan = new Plan(4);
        $secondPlan = new Plan(5);

        $exercise = $this->exercise;
        $exercise->addPlan($plan);
        $updatedExercise = $this->exerciseService->update($exercise->getId(), null, [], [$secondPlan]);
        $this->assertNotNull($updatedExercise);
        $this->assertEquals($secondPlan, $updatedExercise->getPlans()[1]);
        $this->assertCount(2, $updatedExercise->getPlans());
    }

    /**
     * @throws Exception
     */
    public function testUpdateWorkoutExercise(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->exercise);
        $this->repoMock->method('findBy')->willReturn([$this->exercise]);

        $workout = new Workout(false, 92);
        $secondWorkout = new Workout(true, 89);

        $exercise = $this->exercise;
        $exercise->addWorkout($workout);
        $updatedExercise = $this->exerciseService->update($exercise->getId(), null, [], [], [$secondWorkout]);
        $this->assertNotNull($updatedExercise);
        $this->assertEquals($secondWorkout, $updatedExercise->getWorkouts()[1]);
        $this->assertCount(2, $updatedExercise->getWorkouts());
    }

    public function testUpdateMuscleGroupExercise(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->exercise);
        $this->repoMock->method('findBy')->willReturn([$this->exercise]);

        $muscleGroup = new MuscleGroup('Biceps');
        $secondMuscleGroup = new MuscleGroup('Triceps');

        $exercise = $this->exercise;
        $exercise->addMuscleGroup($muscleGroup);
        $updatedExercise = $this->exerciseService->update($exercise->getId(), null, [], [], [], [$secondMuscleGroup]);
        $this->assertNotNull($updatedExercise);
        $this->assertEquals($secondMuscleGroup, $updatedExercise->getMuscleGroups()[1]);
        $this->assertCount(2, $updatedExercise->getMuscleGroups());
    }
}
