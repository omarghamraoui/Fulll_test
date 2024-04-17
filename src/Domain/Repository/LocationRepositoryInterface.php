<?php

namespace App\Domain\Repository;

use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;

interface LocationRepositoryInterface
{
    public function save(Location $location, bool $flush = false): void;

    public function findLocationByLatLngVehicle(float $latitude, float $longitude, ?Vehicle $vehicle = null): ?Location;
}
