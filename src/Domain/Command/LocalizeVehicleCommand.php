<?php

declare(strict_types=1);

namespace App\Domain\Command;

final class LocalizeVehicleCommand
{
    public function __construct(
        private readonly string $fleetId,
        private readonly string $plateNumber,
        private readonly float $latitude,
        private readonly float $longitude
    ) {
    }

    public function fleetId(): string
    {
        return $this->fleetId;
    }

    public function plateNumber(): string
    {
        return $this->plateNumber;
    }

    public function latitude(): float
    {
        return $this->latitude;
    }

    public function longitude(): float
    {
        return $this->longitude;
    }
}
