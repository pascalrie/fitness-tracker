<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercise>
 */
class ExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

    /**
     * @throws \Exception
     */
    public function add(Exercise $exercise, bool $flush = false): void
    {
        $shouldBeNull = $this->findOneBy(['uniqueName' => $exercise->getUniqueName()]);
        if (null !== $shouldBeNull) {
            throw new \Exception('Exercise already added');
        }
        $this->persist($exercise);

        if ($flush) {
            $this->flush();
        }
    }

    public function remove(Exercise $exercise, bool $flush = false): void
    {
        $this->getEntityManager()->remove($exercise);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function persist(Exercise $exercise): void {
        $this->getEntityManager()->persist($exercise);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
