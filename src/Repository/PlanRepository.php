<?php

namespace App\Repository;

use App\Entity\Plan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plan>
 */
class PlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plan::class);
    }

    public function add(Plan $plan, bool $flush = false): void
    {
        $this->persist($plan);

        if ($flush) {
            $this->flush();
        }
    }

    public function remove(Plan $plan, bool $flush = false): void
    {
        $this->getEntityManager()->remove($plan);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function persist(Plan $plan): void {
        $this->getEntityManager()->persist($plan);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
