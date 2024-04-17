<?php

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\OneToOne(mappedBy: 'location', cascade: ['persist', 'remove'])]
    private ?Vehicle $vehicle = null;

    public function __construct(
        #[ORM\Column]
        private float $latitude,
        #[ORM\Column]
        private float $longitude
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function latitude(): float
    {
        return $this->latitude;
    }

    public function longitude(): float
    {
        return $this->longitude;
    }

    public function isEqual(Location $location): bool
    {
        return $this->latitude === $location->latitude && $this->longitude === $location->longitude;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }
}
