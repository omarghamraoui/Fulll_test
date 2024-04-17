<?php

declare(strict_types=1);

namespace App\Domain\Handler;

use App\App\Dto\AddVehicleDto;
use App\App\Dto\ParkVehicleDto;
use App\Domain\Command\LocalizeVehicleCommand;
use App\Domain\Command\RegisterVehicleCommand;
use App\Domain\Factory\VehicleFactory;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\Domain\Service\ParkVehicleService;
use App\Domain\Service\VehicleService;

final class LocalizeVehicleHandler
{
    public function __construct(
        private readonly ParkVehicleService $parkVehicleService,
    ) {
    }

    public function handle(LocalizeVehicleCommand $command): void
    {
        $parkVehicle = new ParkVehicleDto(
            $command->fleetId(),
            $command->plateNumber(),
            $command->latitude(),
            $command->longitude()
        );
        $this->parkVehicleService->parkVehicle($parkVehicle);
    }
}
