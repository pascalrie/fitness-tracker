<?php

namespace App\Repository;

use App\Entity\Set;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Set>
 */
class SetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Set::class);
    }

    public function add(Set $set, bool $flush = false): void
    {
        $this->persist($set);

        if ($flush) {
            $this->flush();
        }
    }

    public function remove(Set $set, bool $flush = false): void
    {
        $this->getEntityManager()->remove($set);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function persist(Set $set): void {
        $this->getEntityManager()->persist($set);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
