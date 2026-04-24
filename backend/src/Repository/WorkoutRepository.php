<?php

namespace App\Repository;

use App\Entity\Workout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workout>
 */
class WorkoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workout::class);
    }

    public function add(Workout $workout, bool $flush = false): void
    {
        $this->persist($workout);

        if ($flush) {
            $this->flush();
        }
    }

    public function remove(Workout $workout, bool $flush = false): void
    {
        $this->getEntityManager()->remove($workout);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function persist(Workout $workout): void {
        $this->getEntityManager()->persist($workout);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
