<?php

namespace App\Tests\Service;

use App\Entity\BodyMeasurement;
use App\Repository\BodyMeasurementRepository;
use App\Service\BodyMeasurementService;
use Doctrine\ORM\EntityManager;
use JetBrains\PhpStorm\NoReturn;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Doctrine\ManagerRegistry;

class BodyMeasurementServiceTest extends TestCase
{
    protected ManagerRegistry $managerRegistry;

    protected ?BodyMeasurement $bodyMeasurement;

    protected ?MockObject $repoMock;

    protected ?BodyMeasurementService $bodyMeasurementService;

    /**
     * @throws Exception
     * @throws \ReflectionException
     */
    public function setUp(): void
    {
        $this->managerRegistry = $this->createMock(ManagerRegistry::class);

        $this->bodyMeasurement = new BodyMeasurement();
        $reflection = new \ReflectionClass($this->bodyMeasurement);
        $property = $reflection->getProperty('id');
        $property->setValue($this->bodyMeasurement, 123);

        $this->repoMock = $this->getMockBuilder(BodyMeasurementRepository::class)
            ->setConstructorArgs([$this->managerRegistry, $this->createMock(EntityManager::class)])
            ->onlyMethods(['add', 'persist', 'flush', 'findBy', 'findAll', 'findOneBy'])
            ->getMock();

        $this->bodyMeasurementService = new BodyMeasurementService($this->repoMock);
    }

    public function tearDown(): void
    {
        $this->repoMock = null;
        $this->bodyMeasurementService = null;
    }

    public function testCreateBodyMeasurement(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->bodyMeasurement);
        $fitnessEval = 80;
        $bodyWeight = 80.5;
        $bodyHeight = 1.83;
        $bmi = 20;

        $createdBodyMeasurement = $this->bodyMeasurementService->create($fitnessEval, $bodyWeight, $bodyHeight, $bmi);

        $this->assertNotNull($createdBodyMeasurement);
        $this->assertEquals($fitnessEval, $createdBodyMeasurement->getFitnessEvaluation());
        $this->assertEquals($bodyWeight, $createdBodyMeasurement->getBodyWeight());
        $this->assertEquals($bodyHeight, $createdBodyMeasurement->getBodyHeight());
        $this->assertEquals($bmi, $createdBodyMeasurement->getBmi());
    }

    public function testBuildIdentifier(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->bodyMeasurement);
        $this->bodyMeasurement->setBodyHeight(80.0);
        $this->bodyMeasurement->setBodyWeight(79);
        $this->bodyMeasurement->setFitnessEvaluation(85);

        $this->bodyMeasurement->buildIdentifier($this->bodyMeasurement);

        $this->assertNotEmpty($this->bodyMeasurement->getIdentifier());
        $this->assertTrue(str_contains($this->bodyMeasurement->getIdentifier(), 80.0));
        $this->assertTrue(str_contains($this->bodyMeasurement->getIdentifier(), 79));
        $this->assertTrue(str_contains($this->bodyMeasurement->getIdentifier(), 85));
    }

    /**
     * @throws \Exception
     */
    public function testUpdateBodyWeightBodyMeasurement(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->bodyMeasurement);
        $this->repoMock->method('findBy')->willReturn([$this->bodyMeasurement]);

        $bodyWeight = 80;
        $updatedBodyMeasurement = $this->bodyMeasurementService->update($this->bodyMeasurement->getId(), $bodyWeight);
        $this->assertNotNull($updatedBodyMeasurement);
        $this->assertEquals($bodyWeight, $updatedBodyMeasurement->getBodyWeight());
    }

    /**
     * @throws \Exception
     */
    public function testUpdateBmiBodyMeasurement(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->bodyMeasurement);
        $this->repoMock->method('findBy')->willReturn([$this->bodyMeasurement]);

        $bmi = 24;
        $createdBodyMeasurement = $this->bodyMeasurement;
        $updatedBodyMeasurement = $this->bodyMeasurementService->update($createdBodyMeasurement->getId(), null, 24);
        $this->assertNotNull($updatedBodyMeasurement);
        $this->assertEquals($bmi, $updatedBodyMeasurement->getBmi());
    }

    /**
     * @throws \Exception
     */
    public function testUpdateFitnessEvalBodyMeasurement(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->bodyMeasurement);
        $this->repoMock->method('findBy')->willReturn([$this->bodyMeasurement]);

        $fitnessEval = 84;
        $createdBodyMeasurement = $this->bodyMeasurement;
        $updatedBodyMeasurement = $this->bodyMeasurementService->update($createdBodyMeasurement->getId(), null, null, $fitnessEval);
        $this->assertNotNull($updatedBodyMeasurement);
        $this->assertEquals($fitnessEval, $updatedBodyMeasurement->getFitnessEvaluation());
    }

    /**
     * @throws \Exception
     */
    public function testUpdateHeightBodyMeasurement(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->bodyMeasurement);
        $this->repoMock->method('findBy')->willReturn([$this->bodyMeasurement]);

        $bodyHeight = 1.73;
        $createdBodyMeasurement = $this->bodyMeasurement;
        $updatedBodyMeasurement = $this->bodyMeasurementService->update($createdBodyMeasurement->getId(), null, null, null, $bodyHeight);
        $this->assertNotNull($updatedBodyMeasurement);
        $this->assertEquals($bodyHeight, $updatedBodyMeasurement->getBodyHeight());
    }

    public function testCalulateBmiBodyMeasurement(): void
    {
        $this->repoMock->method('findOneBy')->willReturn($this->bodyMeasurement);
        $this->repoMock->method('findBy')->willReturn([$this->bodyMeasurement]);
        $bodyWeight = 95;
        $bodyHeight = 1.90;
        $result = $this->bodyMeasurementService->calculateBmi($bodyWeight, $bodyHeight);
        $this->assertNotNull($result);
        $this->assertEquals(26.316, $result);
    }
}
