<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Model\Fleet;
use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;

final class VehicleFactory
{
    public function create(string $plateNumber, ?Location $location = null, ?Fleet $fleet = null): Vehicle
    {
        return new Vehicle($plateNumber, $location, $fleet);
    }
}
