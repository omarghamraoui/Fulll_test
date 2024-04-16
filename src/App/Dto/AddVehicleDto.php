<?php

declare(strict_types=1);

namespace App\App\Dto;

final class AddVehicleDto
{
    public function __construct(
        private readonly string $fleetId,
        private readonly string $type,
        private readonly string $plateNumber,
    ) {
    }

    public function fleetId(): string
    {
        return $this->fleetId;
    }
    public function type(): string
    {
        return $this->type;
    }

    public function plateNumber(): string
    {
        return $this->plateNumber;
    }
}
