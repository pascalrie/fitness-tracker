<?php

namespace App\Repository;

use App\Entity\MuscleGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MuscleGroup>
 */
class MuscleGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MuscleGroup::class);
    }

    public function add(MuscleGroup $muscleGroup, bool $flush = false): void
    {
        $this->persist($muscleGroup);

        if ($flush) {
            $this->flush();
        }
    }

    public function remove(MuscleGroup $muscleGroup, bool $flush = false): void
    {
        $this->getEntityManager()->remove($muscleGroup);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function persist(MuscleGroup $muscleGroup): void {
        $this->getEntityManager()->persist($muscleGroup);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
