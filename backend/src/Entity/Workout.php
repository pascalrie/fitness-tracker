<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
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
    private ?\DateTime $dateOfWorkout = null;

    #[ORM\Column(nullable: true)]
    private ?float $bodyWeight = null;

    #[ORM\Column]
    private ?bool $stretch = false;

    /**
     * @var Collection<int, Execution>
     */
    #[ORM\OneToMany(targetEntity: Execution::class, mappedBy: 'workout', orphanRemoval: true)]
    private Collection $executions;

    /**
     * @var Collection<int, Exercise>
     */
    #[ORM\ManyToMany(targetEntity: Exercise::class, mappedBy: 'workouts')]
    private Collection $exercises;

    /**
     * @var Collection<int, Set>
     */
    #[ORM\OneToMany(targetEntity: Set::class, mappedBy: 'workout', orphanRemoval: true)]
    private Collection $sets;

    public function __construct(?bool $stretch = false, ?float $bodyWeight = null)
    {
        $this->dateOfWorkout = new \DateTime('NOW');
        $this->stretch = $stretch;

        if (null !== $bodyWeight) {
            $this->bodyWeight = $bodyWeight;
        }
        $this->exercises = new ArrayCollection();
        $this->executions = new ArrayCollection();
        $this->sets = new ArrayCollection();
    }

    public function getDateOfWorkout(): ?\DateTime
    {
        return $this->dateOfWorkout;
    }

    public function setDateOfWorkout(\DateTime $dateOfWorkout): static
    {
        $this->dateOfWorkout = $dateOfWorkout;

        return $this;
    }

    public function getBodyWeight(): ?float
    {
        return $this->bodyWeight;
    }

    public function setBodyWeight(?float $bodyWeight): static
    {
        $this->bodyWeight = $bodyWeight;

        return $this;
    }

    public function isStretch(): ?bool
    {
        return $this->stretch;
    }

    public function setStretch(bool $stretch): static
    {
        $this->stretch = $stretch;

        return $this;
    }
    // TODO: Signatur bei Aufrufen anpassen
    public function jsonSerialize(bool $withDateOfWorkout = true, bool $withBodyWeight = true, bool $withStretch = true, bool $withExercises = true, bool $withExecutions = false): array
    {
        $json = [
            'id' => $this->id,
        ];

        if ($withDateOfWorkout) {
            $json['dateOfWorkout'] = $this->dateOfWorkout->format('Y-m-d');
        }

        if ($withBodyWeight) {
            $json['bodyWeight'] = $this->bodyWeight;
        }

        if ($withStretch) {
            $json['stretch'] = $this->stretch;
        }

        if ($withExercises) {
            foreach ($this->getExercises() as $exercise) {
                $json['exercises'][] = $exercise->jsonSerialize();
            }
        }

        if ($withExecutions) {
            foreach ($this->getExecutions() as $execution) {
                $json['executions'][] = $execution->jsonSerialize();
            }
        }
        return $json;
    }

    /**
     * @return Collection<int, Execution>
     */
    public function getExecutions(): Collection
    {
        return $this->executions;
    }

    public function addExecution(Execution $execution): static
    {
        if (!$this->executions->contains($execution)) {
            $this->executions->add($execution);
            $execution->setWorkout($this);
        }

        return $this;
    }

    public function removeExecution(Execution $execution): static
    {
        if ($this->executions->removeElement($execution)) {
            // set the owning side to null (unless already changed)
            if ($execution->getWorkout() === $this) {
                $execution->setWorkout(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Exercise>
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    public function addExercise(Exercise $exercise): static
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
            $exercise->addWorkout($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): static
    {
        if ($this->exercises->removeElement($exercise)) {
            $exercise->removeWorkout($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Set>
     */
    public function getSets(): Collection
    {
        return $this->sets;
    }

    public function addSet(Set $set): static
    {
        if (!$this->sets->contains($set)) {
            $this->sets->add($set);
            $set->setWorkout($this);
        }

        return $this;
    }

    public function removeSet(Set $set): static
    {
        if ($this->sets->removeElement($set)) {
            // set the owning side to null (unless already changed)
            if ($set->getWorkout() === $this) {
                $set->setWorkout(null);
            }
        }

        return $this;
    }
}
