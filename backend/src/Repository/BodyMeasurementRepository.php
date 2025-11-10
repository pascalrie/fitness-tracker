<?php

namespace App\Repository;

use App\Entity\BodyMeasurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BodyMeasurement>
 */
class BodyMeasurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BodyMeasurement::class);
    }

    public function add(BodyMeasurement $bodyMeasurement, bool $flush = false): void
    {
        $this->persist($bodyMeasurement);

        if ($flush) {
            $this->flush();
        }
    }

    public function remove(BodyMeasurement $bodyMeasurement, bool $flush = false): void
    {
        $this->getEntityManager()->remove($bodyMeasurement);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function persist(BodyMeasurement $bodyMeasurement): void {
        $this->getEntityManager()->persist($bodyMeasurement);
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
