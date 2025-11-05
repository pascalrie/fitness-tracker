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
     * @var Collection<int, Exercise>
     */
    #[ORM\OneToMany(targetEntity: Exercise::class, mappedBy: 'workout')]
    private Collection $exercises;

    public function __construct(?bool $stretch = false, ?float $bodyWeight = null)
    {
        $this->dateOfWorkout = new \DateTime('NOW');
        $this->stretch = $stretch;

        if (null !== $bodyWeight) {
            $this->bodyWeight = $bodyWeight;
        }
        $this->exercises = new ArrayCollection();
    }

    public function getExercises(): ArrayCollection
    {
        return $this->exercises;
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

    public function jsonSerialize(bool $withDateOfWorkout = true, bool $withBodyWeight = false, bool $withStretch = true, bool $withExercises = true): array
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
            foreach ($this->exercises as $exercise) {
                $json['exercises'][] = $exercise->jsonSerialize(); // TODO: adjust Exercise->jsonSerialize
            }
        }

        return $json;
    }
}
