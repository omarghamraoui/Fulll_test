<?php

declare(strict_types=1);

namespace App\App\Dto;

final class ParkVehicleDto
{
    public function __construct(
        private readonly string $fleetId,
        private readonly string $type,
        private readonly string $plateNumber,
        private readonly float $latitude,
        private readonly float $longitude
    ) {
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}
