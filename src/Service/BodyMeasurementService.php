<?php

namespace App\Service;

use App\Entity\BodyMeasurement;
use App\Repository\BodyMeasurementRepository;

class BodyMeasurementService
{
    protected BodyMeasurementRepository $bodyMeasurementRepository;

    public function __construct(BodyMeasurementRepository $bodyMeasurementRepository)
    {
        $this->bodyMeasurementRepository = $bodyMeasurementRepository;
    }

    public function create(int $fitnessEvaluation, float $bodyWeight, float $bodyHeight, float $bmi): BodyMeasurement
    {
        $bodyMeasurement = new BodyMeasurement($bodyWeight, $bmi, $fitnessEvaluation, $bodyHeight);
        $this->bodyMeasurementRepository->add($bodyMeasurement, true);
        return $bodyMeasurement;
    }

    public function update(int    $id, ?float $bodyWeight = null, ?float $bmi = null, ?int $fitnessEvaluation = null,
                           ?float $bodyHeight = null): BodyMeasurement
    {
        $oldBodyMeasurement = $this->bodyMeasurementRepository->findOneBy(['id' => $id]);
        $newBodyMeasurement = $this->duplicateEntity($oldBodyMeasurement);
        if ($bodyWeight !== null) {
            $newBodyMeasurement->setBodyWeight($bodyWeight);
        }
        if ($bmi !== null) {
            $newBodyMeasurement->setBmi($bmi);
        }
        if ($fitnessEvaluation !== null) {
            $newBodyMeasurement->setFitnessEvaluation($fitnessEvaluation);
        }
        if ($bodyHeight !== null) {
            $newBodyMeasurement->setBodyHeight($bodyHeight);
        }

        $this->bodyMeasurementRepository->flush();
        return $newBodyMeasurement;
    }

    public function delete(int $id): void
    {
        $bodyMeasurement = $this->bodyMeasurementRepository->findOneBy(['id' => $id]);
        $this->bodyMeasurementRepository->remove($bodyMeasurement, true);
    }

    public function show(int $id): ?BodyMeasurement
    {
        return $this->bodyMeasurementRepository->findOneBy(['id' => $id]);
    }

    public function list(): array
    {
        return $this->bodyMeasurementRepository->findAll();
    }

    public function calculateBmi(float $bodyWeight, float $bodyHeight): float
    {
        return $bodyWeight / (pow($bodyHeight, 2));
    }

    private function duplicateEntity(BodyMeasurement $bodyMeasurement): BodyMeasurement
    {
        return $this->create($bodyMeasurement->getFitnessEvaluation(),
            $bodyMeasurement->getBodyWeight(), $bodyMeasurement->getBodyHeight(),
            $bodyMeasurement->getBmi());
    }
}
