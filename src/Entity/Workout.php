<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $day = null;

    #[ORM\Column(nullable: true)]
    private ?float $bodyWeight = null;

    #[ORM\Column]
    private ?bool $stretch = null;

    /**
     * @var Collection<int, Exercise>
     */
    #[ORM\OneToMany(targetEntity: Exercise::class, mappedBy: 'workout')]
    private Collection $exercises {
        get {
            return $this->exercises;
        }
    }

    public function __construct()
    {
        $this->exercises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?\DateTime
    {
        return $this->day;
    }

    public function setDay(\DateTime $day): static
    {
        $this->day = $day;

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

    public function addExercise(Exercise $exercise): static
    {
        if (!$this->exercises->contains($exercise)) {
            $this->exercises->add($exercise);
            $exercise->setWorkout($this);
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): static
    {
        if ($this->exercises->removeElement($exercise)) {
            // set the owning side to null (unless already changed)
            if ($exercise->getWorkout() === $this) {
                $exercise->setWorkout(null);
            }
        }

        return $this;
    }
}
