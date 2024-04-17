<?php

declare(strict_types=1);

namespace App\Domain\Command;

final class CreateFleetCommand
{
    public function __construct(
        private readonly string $fleetId
    ) {
    }

    public function fleetId(): string
    {
        return $this->fleetId;
    }
}
