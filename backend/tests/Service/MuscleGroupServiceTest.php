<?php

namespace App\Tests\Service;

use App\Entity\Exercise;
use App\Entity\MuscleGroup;
use App\Repository\ExerciseRepository;
use App\Repository\MuscleGroupRepository;
use App\Service\MuscleGroupService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class MuscleGroupServiceTest extends TestCase
{
    protected ManagerRegistry $managerRegistry;

    protected ?MuscleGroup $muscleGroup;

    protected ?MockObject $repoMock;

    protected ?MuscleGroupService $muscleGroupService;

    protected ?MockObject $exerciseRepoMock;

    /**
     * @throws \ReflectionException
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);
        $this->muscleGroup = new MuscleGroup();
        $reflection = new ReflectionClass($this->muscleGroup);
        $property = $reflection->getProperty('id');
        $property->setValue($this->muscleGroup,123);

        $this->repoMock = $this->getMockBuilder(MuscleGroupRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->exerciseRepoMock = $this->getMockBuilder(ExerciseRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->muscleGroupService = new MuscleGroupService($this->repoMock);
    }

    public function tearDown(): void
    {
        $this->repoMock = null;
        $this->muscleGroupService = null;
        $this->muscleGroup = null;
    }

    public function testCreateMuscleGroup(): void
    {
        $name = 'muscle group 1';
        $muscleGroup = $this->muscleGroupService->create($name);
        $this->assertInstanceOf(MuscleGroup::class, $muscleGroup);
        $this->assertEquals($name, $muscleGroup->getName());
    }

    /** not testable due to uniqueName check in combination with mocking *
     * public function testUpdateNameMuscleGroup(): void
     * {
     * $this->repoMock->method('findOneBy')->willReturn($this->muscleGroup);
     * $this->repoMock->method('findBy')->willReturn([$this->muscleGroup]);
     *
     * $oldName = 'muscle group 2';
     * $newName = 'muscle group 3';
     *
     * $this->muscleGroup->setName($oldName);
     *
     * $muscleGroup = $this->muscleGroupService->update($this->muscleGroup->getId(), $newName);
     * $this->assertInstanceOf(MuscleGroup::class, $this->muscleGroup);
     * $this->assertEquals($newName, $this->muscleGroup->getName());
     * }
     * @throws \Exception
     */
    public function testUpdateExerciseMuscleGroup(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->muscleGroup);
        $this->repoMock->method('findBy')->willReturn([$this->muscleGroup]);

        $exercise = new Exercise('unique name 4');

        $muscleGroup = $this->muscleGroup;
        $muscleGroup->addExercise($exercise);
        $updatedMuscleGroup = $this->muscleGroupService->update($muscleGroup->getId(), null, [$exercise]);
        $this->assertNotNull($updatedMuscleGroup);
        $this->assertEquals($exercise, $updatedMuscleGroup->getExercises()[0]);
        $this->assertCount(1, $updatedMuscleGroup->getExercises());
    }
}
