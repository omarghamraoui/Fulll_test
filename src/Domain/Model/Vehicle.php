<?php

namespace App\Domain\Model;

final class Vehicle
{
    public function __construct(
        private string $type,
        private string $plateNumber,
        private ?Location $location = null
    ) {
    }

    public function type(): string
    {
        return $this->type;
    }

    public function plateNumber() : string
    {
        return $this->plateNumber;
    }
    public function checkLocation(?Location $location = null) : bool
    {
        if (null === $this->location) {
            return false;
        }

        return $this->location->isEqual($location);
    }

    public function parkAt(Location $location) : Vehicle
    {
        return new Vehicle($this->type(), $this->plateNumber(), $location);
    }
}
