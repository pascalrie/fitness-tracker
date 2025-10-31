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
    private ?int $id = null {
        get {
            return $this->id;
        }
    }

    /**
     * @var Collection<int, MuscleGroup>
     */
    #[ORM\ManyToMany(targetEntity: MuscleGroup::class)]
    private Collection $muscleGroup {
        get {
            return $this->muscleGroup;
        }
    }

    /**
     * @var Collection<int, Set>
     */
    #[ORM\OneToMany(targetEntity: Set::class, mappedBy: 'exercise', orphanRemoval: true)]
    private Collection $sets {
        get {
            return $this->sets;
        }
    }

    #[ORM\Column]
    private ?\DateTime $time = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'exercises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Workout $workout = null;

    public function __construct()
    {
        $this->muscleGroup = new ArrayCollection();
        $this->sets = new ArrayCollection();
    }

    public function addMuscleGroup(MuscleGroup $muscleGroup): static
    {
        if (!$this->muscleGroup->contains($muscleGroup)) {
            $this->muscleGroup->add($muscleGroup);
        }

        return $this;
    }

    public function removeMuscleGroup(MuscleGroup $muscleGroup): static
    {
        $this->muscleGroup->removeElement($muscleGroup);

        return $this;
    }

    public function addSet(Set $set): static
    {
        if (!$this->sets->contains($set)) {
            $this->sets->add($set);
            $set->setExercise($this);
        }

        return $this;
    }

    public function removeSet(Set $set): static
    {
        if ($this->sets->removeElement($set)) {
            // set the owning side to null (unless already changed)
            if ($set->getExercise() === $this) {
                $set->setExercise(null);
            }
        }

        return $this;
    }

    public function getTime(): ?\DateTime
    {
        return $this->time;
    }

    public function setTime(\DateTime $time): static
    {
        $this->time = $time;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
