<?php

namespace App\Service;

use App\Entity\BodyMeasurement;
use App\Repository\BodyMeasurementRepository;
use Doctrine\ORM\EntityNotFoundException;

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
        $bodyMeasurement = $this->buildIdentifier($bodyMeasurement);

        $this->bodyMeasurementRepository->add($bodyMeasurement, true);
        return $bodyMeasurement;
    }

    /**
     * @throws \Exception
     */
    public function update(int    $id, ?float $bodyWeight = null, ?float $bmi = null, ?int $fitnessEvaluation = null,
                           ?float $bodyHeight = null): BodyMeasurement
    {

        $bodyMeasurement = $this->show($id);
        $bodyMeasurement->setUpdatedAt(new \DateTime());
        $bodyMeasurement = $this->buildIdentifier($bodyMeasurement);

        if (!$bodyMeasurement) {
            throw new EntityNotFoundException('Body Measurement with id ' . $id . ' not found');
        }
        if ($bodyWeight !== null) {
            $bodyMeasurement->setBodyWeight($bodyWeight);
        }
        if ($bmi !== null) {
            $bodyMeasurement->setBmi($bmi);
        }
        if ($fitnessEvaluation !== null) {
            $bodyMeasurement->setFitnessEvaluation($fitnessEvaluation);
        }
        if ($bodyHeight !== null) {
            $bodyMeasurement->setBodyHeight($bodyHeight);
        }

        $this->bodyMeasurementRepository->flush();
        return $bodyMeasurement;
    }

    public function delete(int $id): void
    {
        $bodyMeasurement = $this->bodyMeasurementRepository->findBy(['id' => $id])[0];
        if (!$bodyMeasurement) {
            throw new EntityNotFoundException('Body Measurement with id ' . $id . ' not found for deletion.');
        }
        $this->bodyMeasurementRepository->remove($bodyMeasurement, true);
    }

    public function show(int $id): ?BodyMeasurement
    {
        return $this->bodyMeasurementRepository->findBy(['id' => $id])[0];
    }

    public function list(): array
    {
        return $this->bodyMeasurementRepository->findAll();
    }

    public function calculateBmi(float $bodyWeight, float $bodyHeight): float
    {
        return round($bodyWeight / (pow($bodyHeight, 2)), 3);
    }

    public function getLatest(): BodyMeasurement
    {
        return $this->bodyMeasurementRepository->findOneBy([], ['createdAt' => 'DESC']);
    }


    public function buildIdentifier(BodyMeasurement $bodyMeasurement): BodyMeasurement
    {
        $weight = $bodyMeasurement->getBodyWeight();
        $height = $bodyMeasurement->getBodyHeight();
        $fitnessEvaluation = $bodyMeasurement->getFitnessEvaluation();
        $updatedAt = $bodyMeasurement->getUpdatedAt()->format('d-m-YY H:i:s');

        $bodyMeasurement->setIdentifier('Fitness Eval: ' . $fitnessEvaluation . ' Weight: ' . $weight . ' Height: ' . $height . ' (' . $updatedAt . ')');

        return $bodyMeasurement;
    }
}
