<?php

namespace App\Infra\Repository;

use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\VehicleRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VehicleRepository extends ServiceEntityRepository implements VehicleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findVehicleByPlateNumber(string $plateNumber): ?Vehicle
    {
        /** @var ?Vehicle $vehicle */
        $vehicle =  $this->findOneBy(['plateNumber' => $plateNumber]);
        return $vehicle;
    }

    public function findVehicleByPlateNumberAndFleet(string $plateNumber, Fleet $fleet): ?Vehicle
    {
        /** @var ?Vehicle $vehicle */
        $vehicle =  $this->findOneBy(['plateNumber' => $plateNumber, 'fleet' => $fleet]);
        return $vehicle;
    }

    public function save(Vehicle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
