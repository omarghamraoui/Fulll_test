<?php

namespace App\Infra\Repository;

use App\Domain\Model\Fleet;
use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\Repository\LocationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

class LocationRepository extends ServiceEntityRepository implements LocationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function save(Location $location, bool $flush = false): void
    {
        $this->getEntityManager()->persist($location);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLocationByLatLngVehicle(float $latitude, float $longitude, ?Vehicle $vehicle = null): ?Location
    {
        $query = $this->createQueryBuilder('l');
        $query
            ->where($query->expr()->eq('l.latitude', ':lat'))
            ->andWhere($query->expr()->eq('l.longitude', ':lng'))
            ->setParameter('lat', $latitude)
            ->setParameter('lng', $longitude);
        if (null !== $vehicle) {
            $query
                ->innerJoin('l.vehicle', 'v', Join::WITH, 'v.id = :vehicle')
                ->setParameter('vehicle', $vehicle);
        }
        /** @var ?Location $location */
        $location = $query->getQuery()->getOneOrNullResult();
        return $location;
    }
}
