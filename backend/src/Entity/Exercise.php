<?php

namespace App\Entity;

use App\Repository\ExerciseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var Collection<int, Execution>
     */
    #[ORM\OneToMany(targetEntity: Execution::class, mappedBy: 'exercise', orphanRemoval: true)]
    private Collection $executions;

    #[ORM\Column(length: 255)]
    private ?string $uniqueName = null;

    /**
     * @var Collection<int, Plan>
     */
    #[ORM\ManyToMany(targetEntity: Plan::class, mappedBy: 'exercises')]
    private Collection $plans;

    /**
     * @var Collection<int, Workout>
     */
    #[ORM\ManyToMany(targetEntity: Workout::class, inversedBy: 'exercises')]
    private Collection $workouts;

    /**
     * @var Collection<int, MuscleGroup>
     */
    #[ORM\ManyToMany(targetEntity: MuscleGroup::class, mappedBy: 'exercises')]
    private Collection $muscleGroups;

    public function __construct(string $uniqueName)
    {
        $this->uniqueName = $uniqueName;

        $this->executions = new ArrayCollection();
        $this->plans = new ArrayCollection();
        $this->workouts = new ArrayCollection();
        $this->muscleGroups = new ArrayCollection();
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
            $execution->setExercise($this);
        }

        return $this;
    }

    public function removeExecution(Execution $execution): static
    {
        if ($this->executions->removeElement($execution)) {
            // set the owning side to null (unless already changed)
            if ($execution->getExercise() === $this) {
                $execution->setExercise(null);
            }
        }

        return $this;
    }

    public function getUniqueName(): ?string
    {
        return $this->uniqueName;
    }

    public function setUniqueName(string $uniqueName): static
    {
        $this->uniqueName = $uniqueName;

        return $this;
    }

    /**
     * @return Collection<int, Plan>
     */
    public function getPlans(): Collection
    {
        return $this->plans;
    }

    public function addPlan(Plan $plan): static
    {
        if (!$this->plans->contains($plan)) {
            $this->plans->add($plan);
            $plan->addExercise($this);
        }

        return $this;
    }

    public function removePlan(Plan $plan): static
    {
        if ($this->plans->removeElement($plan)) {
            $plan->removeExercise($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Workout>
     */
    public function getWorkouts(): Collection
    {
        return $this->workouts;
    }

    public function addWorkout(Workout $workout): static
    {
        if (!$this->workouts->contains($workout)) {
            $this->workouts->add($workout);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): static
    {
        $this->workouts->removeElement($workout);

        return $this;
    }

    /**
     * @return Collection<int, MuscleGroup>
     */
    public function getMuscleGroups(): Collection
    {
        return $this->muscleGroups;
    }

    public function addMuscleGroup(MuscleGroup $muscleGroup): static
    {
        if (!$this->muscleGroups->contains($muscleGroup)) {
            $this->muscleGroups->add($muscleGroup);
            $muscleGroup->addExercise($this);
        }

        return $this;
    }

    public function removeMuscleGroup(MuscleGroup $muscleGroup): static
    {
        if ($this->muscleGroups->removeElement($muscleGroup)) {
            $muscleGroup->removeExercise($this);
        }

        return $this;
    }

    public function jsonSerialize(bool $withMuscleGroups = true, $withWorkouts = false, $withExecutions = false, $withPlans = true): array
    {
        $json = [
            'id' => $this->id,
            'uniqueName' => $this->uniqueName,
        ];

        if ($withMuscleGroups) {
            foreach ($this->getMuscleGroups() as $muscleGroup) {
                $json['muscleGroups'][] = $muscleGroup->jsonSerialize();
            }
        }
        if ($withWorkouts) {
            foreach ($this->getWorkouts() as $workout) {
                $json['workouts'][] = $workout->jsonSerialize();
            }
        }
        if ($withExecutions) {
            foreach ($this->getExecutions() as $execution) {
                $json['executions'][] = $execution->jsonSerialize();
            }
        }
        if ($withPlans) {
            foreach ($this->getPlans() as $plan) {
                $json['plans'][] = $plan->jsonSerialize();
            }
        }

        return $json;
    }
}
