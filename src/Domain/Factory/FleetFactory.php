<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\Model\Fleet;

final class FleetFactory
{
    public function create(string $fleetId): Fleet
    {
        return new Fleet($fleetId);
    }
}
