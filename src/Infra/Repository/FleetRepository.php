<?php

namespace App\Infra\Repository;

use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FleetRepository extends ServiceEntityRepository implements FleetRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

    public function findFleetById(string $id): ?Fleet
    {
        /** @var ?Fleet $fleet */
        $fleet = $this->findOneBy(['fleetId' => $id]);
        return $fleet;
    }

    public function save(Fleet $fleet, bool $flush = false): void
    {
        $this->getEntityManager()->persist($fleet);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
