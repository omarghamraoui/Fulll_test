<?php

namespace App\Domain\Model;

use Doctrine\Common\Collections\Criteria;
use Exception;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Fleet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'fleet', cascade: ['persist'])]
    private Collection $vehicles;

    public function __construct(
        #[ORM\Column(length: 255, unique: true)]
        private string $fleetId
    ) {
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @throws Exception
     */
    public function addVehicle(Vehicle $vehicle): void
    {
        if (true === $this->has($vehicle->plateNumber())) {
            throw new Exception('Vehicle already registered');
        }
        $this->vehicles[$vehicle->plateNumber()] = $vehicle;
    }

    public function has(string $plateNumber): bool
    {
        return isset($this->vehicles[$plateNumber]);
    }

    /**
     * @throws Exception
     */
    public function parkVehicle(Vehicle $vehicle, Location $location): void
    {
        $this->isAlreadyParked($vehicle->plateNumber(), $location);

        $this->vehicles[$vehicle->plateNumber()] = $vehicle->parkAt($location);
    }

    /**
     * @throws Exception
     */
    public function isAlreadyParked(string $plateNumber, Location $location): bool
    {
        $vehicle = $this->find($plateNumber);
        if ($vehicle === null) {
            throw new Exception('Vehicle not found');
        }
        $bool = $vehicle->checkLocation($location);
        if ($bool) {
            throw new Exception('Vehicle Already parked');
        }

        return $bool;
    }

    public function find(string $plateNumber): ?Vehicle
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('plateNumber', $plateNumber));
        $vehicles = $this->vehicles->matching($criteria);
        return !$vehicles->isEmpty() ? $vehicles->first() : null ;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }
}
