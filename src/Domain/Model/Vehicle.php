<?php

namespace App\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\UniqueConstraint(name: "fleet_vehicle", columns: ["fleet_id", "plate_number"])]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct(
        #[ORM\Column(length: 255)]
        private string $plateNumber,
        #[ORM\OneToOne(inversedBy: 'vehicle', cascade: ['persist', 'remove'])]
        private ?Location $location = null,
        #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'vehicle')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Fleet $fleet = null
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function plateNumber(): string
    {
        return $this->plateNumber;
    }
    public function checkLocation(?Location $location = null): bool
    {
        if (null === $this->location || null === $location) {
            return false;
        }
        return $this->location->isEqual($location);
    }

    public function parkAt(Location $location): Vehicle
    {
        $this->location = $location;
        return $this;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    public function hasLocation(): bool
    {
        return $this->location !== null;
    }
}
