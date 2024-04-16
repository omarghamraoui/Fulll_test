<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;

final class VehicleFactory
{
    public function create(string $type, string $plateNumber, ?Location $location = null): Vehicle
    {
        return new Vehicle($type, $plateNumber, $location);
    }
}
