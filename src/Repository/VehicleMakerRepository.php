<?php

namespace App\Repository;

use App\Entity\VehicleMaker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehicleMaker>
 */
class VehicleMakerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehicleMaker::class);
    }

    public function findMakersByVehicleType(string $type): array
    {
        return $this->createQueryBuilder('vm')
            ->join('vm.vehicles', 'v')
            ->where('v.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();
    }
}
