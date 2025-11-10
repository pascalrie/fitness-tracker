<?php

namespace App\Repository;

use App\Entity\Execution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Execution>
 */
class ExecutionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Execution::class);
    }

    public function add(Execution $execution, bool $flush = false): void
    {
        $this->persist($execution);

        if ($flush) {
            $this->flush();
        }
    }

    public function remove(Execution $execution, bool $flush = false): void
    {
        $this->getEntityManager()->remove($execution);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function persist(Execution $execution): void {
        $this->getEntityManager()->persist($execution);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
