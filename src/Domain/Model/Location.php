<?php

namespace App\Domain\Model;

final class Location
{
    public function __construct(
        private float $latitude,
        private float $longitude
    ) {
    }

    public function latitude() : float
    {
        return $this->latitude;
    }

    public function longitude() : float
    {
        return $this->longitude;
    }

    public function isEqual(Location $location) : bool
    {
        return $this->latitude === $location->latitude && $this->longitude === $location->longitude;
    }
}
