<?php

declare(strict_types=1);

namespace App\Domain\Command;

final class RegisterVehicleCommand
{
    public function __construct(
        private readonly string $fleetId,
        private readonly string $plateNumber
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
}
