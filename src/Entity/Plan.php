<?php

namespace App\Entity;

use App\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanRepository::class)]
class Plan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Exercise>
     */
    #[ORM\ManyToMany(targetEntity: Exercise::class, inversedBy: 'plans')]
    private Collection $exercises;

    #[ORM\Column(nullable: true)]
    private ?int $totalDaysOfTraining = null;

    #[ORM\Column]
    private ?\DateTime $startDate = null;

    #[ORM\Column]
    private ?int $trainingTimesAWeek = null;

    /**
     * @var int|null
     * 1 = whole body
     * 2 = split into upper and lower body
     * ...
     */
    #[ORM\Column]
    private ?int $split = null;

    #[ORM\Column]
    private ?\DateTime $updatedAt = null;

    public function __construct(?int $daysOfTraining = null, ?int $trainingTimesAWeek = 3, ?int $split = 1)
    {
        $this->exercises = new ArrayCollection();
        $this->startDate = new \DateTime('NOW');
        $this->updatedAt = new \DateTime('NOW');
        $this->totalDaysOfTraining = $daysOfTraining;
        $this->trainingTimesAWeek = $trainingTimesAWeek;
        $this->split = $split;
    }

    public function getId(): ?int
    {
        return $this->id;
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
        }

        return $this;
    }

    public function removeExercise(Exercise $exercise): static
    {
        $this->exercises->removeElement($exercise);

        return $this;
    }

    public function getTotalDaysOfTraining(): ?int
    {
        return $this->totalDaysOfTraining;
    }

    public function setTotalDaysOfTraining(?int $totalDaysOfTraining): static
    {
        $this->totalDaysOfTraining = $totalDaysOfTraining;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getTrainingTimesAWeek(): ?int
    {
        return $this->trainingTimesAWeek;
    }

    public function setTrainingTimesAWeek(int $trainingTimesAWeek): static
    {
        $this->trainingTimesAWeek = $trainingTimesAWeek;

        return $this;
    }

    public function getSplit(): ?int
    {
        return $this->split;
    }

    public function setSplit(int $split): static
    {
        $this->split = $split;

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

    public function jsonSerialize(bool $withExercises = false, bool $withTotalDaysOfTraining = true, bool $withTrainingTimesAWeek = true, bool $withSplit = true): array
    {
        $json = [
            'id' => $this->id,
            'startDate' => $this->startDate->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];

        if ($withExercises) {
            foreach ($this->getExercises() as $exercise) {
                $json += ['Exercise with id: ' . $exercise->getId() => $exercise->jsonSerialize()]; //TODO: adjust JsonSerialize
            }
        }

        if ($withTotalDaysOfTraining) {
            $json['totalDaysOfTraining'] = $this->totalDaysOfTraining;
        }

        if ($withTrainingTimesAWeek) {
            $json['trainingTimesAWeek'] = $this->trainingTimesAWeek;
        }

        if ($withSplit) {
            $json['split'] = $this->split;
        }

        return $json;
    }
}
