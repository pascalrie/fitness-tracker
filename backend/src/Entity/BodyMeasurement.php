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

    #[ORM\Column]
    private ?float $bodyHeight = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTime $updatedAt = null;

    #[ORM\Column(length: 255)]
    private ?string $identifier = null;

    public function __construct(?float $bodyWeight = null, ?float $bmi = null, ?int $fitnessEvaluation = null, ?float $bodyHeight = null)
    {
        if (null !== $bodyWeight) {
            $this->bodyWeight = $bodyWeight;
        }

        if (null !== $bmi) {
            $this->bmi = $bmi;
        }

        if (null !== $fitnessEvaluation) {
            $this->fitnessEvaluation = $fitnessEvaluation;
        }

        if (null !== $bodyHeight) {
            $this->bodyHeight = $bodyHeight;
        }

        $this->setCreatedAt(new \DateTimeImmutable('NOW'));
        $this->setUpdatedAt(new \DateTime('NOW'));
    }

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

    public function getBodyHeight(): ?float
    {
        return $this->bodyHeight;
    }

    public function setBodyHeight(float $bodyHeight): static
    {
        $this->bodyHeight = $bodyHeight;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function jsonSerialize(bool $withBodyWeight = true, bool $withBmi = true, bool $withFitnessEvaluation = true, bool $withBodyHeight = true): array
    {
        $json = [
            'id' => $this->id,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];

        if ($withBodyWeight) {
            $json['bodyWeight'] = $this->bodyWeight;
        }

        if ($withBmi) {
            $json['bmi'] = $this->bmi;
        }

        if ($withFitnessEvaluation) {
            $json['fitnessEvaluation'] = $this->fitnessEvaluation;
        }

        if ($withBodyHeight) {
            $json['bodyHeight'] = $this->bodyHeight;
        }

        return $json;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }
}
