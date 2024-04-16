<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Model\Location;

final class LocationFactory
{
    public function create(float $latitude, float $longitude): Location
    {
        return new Location($latitude, $longitude);
    }
}
