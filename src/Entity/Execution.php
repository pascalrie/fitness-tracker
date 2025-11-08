<?php

namespace App\Entity;

use App\Repository\ExecutionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExecutionRepository::class)]
#[ORM\Table(name: '`execution`')]
class Execution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column]
    private ?int $repetitions = null;

    #[ORM\ManyToOne(inversedBy: 'executions')]
    #[ORM\JoinColumn(nullable: false)]
    private Exercise $exercise;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // Weight e.g. null in exercises with own bodyweight
    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\ManyToOne(inversedBy: 'executions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Workout $workout = null;

    public function __construct(Exercise $exercise, float $weight = 0, ?int $repetitions = 12, Workout $workout = null)
    {
        $this->createdAt = new \DateTimeImmutable('NOW');
        $this->exercise = $exercise;
        $this->weight = $weight;
        $this->repetitions = $repetitions;
        $this->workout = $workout;
    }
    public function getRepetitions(): ?int
    {
        return $this->repetitions;
    }

    public function setRepetitions(int $repetitions): static
    {
        $this->repetitions = $repetitions;

        return $this;
    }

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): static
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function jsonSerialize(bool $withRepetitions = true, $withWeight = true, bool $withExercise = true, bool $withWorkout = true): array
    {
        $json = [
            'id' => $this->id,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
        ];

        if ($withRepetitions) {
            $json['repetitions'] = $this->repetitions;
        }

        if ($withWeight) {
            $json['weight'] = $this->weight;
        }

        if ($withExercise) {
            $json['exercise'] = $this->getExercise()->jsonSerialize();
        }

        if ($withWorkout) {
            $json['workout'] = $this->getWorkout()->jsonSerialize();
        }

        return $json;
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

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getWorkout(): ?Workout
    {
        return $this->workout;
    }

    public function setWorkout(?Workout $workout): static
    {
        $this->workout = $workout;

        return $this;
    }
}
