<?php

namespace App\Entity;

use App\Repository\BodyMeasurementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BodyMeasurementRepository::class)]
class BodyMeasurement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $bodyWeight = null;

    #[ORM\Column]
    private ?float $bmi = null;

    #[ORM\Column]
    private ?int $fitnessEvaluation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBodyWeight(): ?float
    {
        return $this->bodyWeight;
    }

    public function setBodyWeight(float $bodyWeight): static
    {
        $this->bodyWeight = $bodyWeight;

        return $this;
    }

    public function getBmi(): ?float
    {
        return $this->bmi;
    }

    public function setBmi(float $bmi): static
    {
        $this->bmi = $bmi;

        return $this;
    }

    public function getFitnessEvaluation(): ?int
    {
        return $this->fitnessEvaluation;
    }

    public function setFitnessEvaluation(int $fitnessEvaluation): static
    {
        $this->fitnessEvaluation = $fitnessEvaluation;

        return $this;
    }
}
