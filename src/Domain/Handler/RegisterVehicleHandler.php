<?php

declare(strict_types=1);

namespace App\Domain\Handler;

use App\App\Dto\AddVehicleDto;
use App\Domain\Command\RegisterVehicleCommand;
use App\Domain\Factory\VehicleFactory;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\Repository\VehicleRepositoryInterface;
use App\Domain\Service\VehicleService;

final class RegisterVehicleHandler
{
    public function __construct(
        private readonly VehicleService $vehicleService,
        private readonly VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    public function handle(RegisterVehicleCommand $command): void
    {
        $addVehicleDto = new AddVehicleDto($command->fleetId(), $command->plateNumber());
        $vehicle = $this->vehicleService->register($addVehicleDto);
        $this->vehicleRepository->save($vehicle, true);
    }
}
