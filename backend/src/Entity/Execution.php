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

    // Weight e.g. 0 in exercises with own body-weight
    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\ManyToOne(inversedBy: 'executions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Workout $workout = null;

    #[ORM\ManyToOne(inversedBy: 'execution')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Set $associatedSet = null;

    #[ORM\Column(length: 255)]
    private ?string $identifier = null;

    public function __construct(Exercise $exercise = null, Set $set = null, float $weight = 0, ?int $repetitions = 12, Workout $workout = null)
    {
        $this->createdAt = new \DateTimeImmutable('NOW');
        if ($set !== null) {
            $this->associatedSet = $set;
        }
        $this->weight = $weight;
        $this->repetitions = $repetitions;
        $this->workout = $workout;
        $this->setIdentifier('Created at: ' . $this->getCreatedAt()
                 ->format('d-m-Y H:i:s'));
        if ($exercise !== null) {
            $this->exercise = $exercise;
            $this->buildIdentifier();
        }
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

    public function jsonSerialize(bool $withRepetitions = true, bool $withWeight = true, bool $withExercise = true,
                                  bool $withWorkout = true, bool $withSet = true, bool $withIdentifier = true): array
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

        if ($withSet) {
            $json['set'] = $this->getAssociatedSet()->jsonSerialize();
        }

        if ($withIdentifier) {
            $json['identifier'] = $this->getIdentifier();
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

    public function getAssociatedSet(): ?Set
    {
        return $this->associatedSet;
    }

    public function setAssociatedSet(?Set $associatedSet): static
    {
        $this->associatedSet = $associatedSet;

        return $this;
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

    public function buildIdentifier(): void
    {
        $datetime = $this->getCreatedAt()->format('d-m-Y H:i:s');
        $weight = $this->getWeight();
        $repetitions = $this->getRepetitions();
        $exerciseName = $this->getExercise()->getUniqueName();
        $this->setIdentifier($exerciseName . ' Weight: ' . $weight . ' Repetitions: ' . $repetitions
            . ' (' . $datetime . ')');
    }
}
