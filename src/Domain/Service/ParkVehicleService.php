<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\App\Dto\ParkVehicleDto;
use App\Domain\Factory\LocationFactory;
use App\Domain\Factory\VehicleFactory;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use Exception;

final class ParkVehicleService
{
    public function __construct(
        private readonly FleetRepositoryInterface $fleetRepository,
        private readonly VehicleFactory $vehicleFactory,
        private readonly LocationFactory $locationFactory
    ) {
    }

    public function parkVehicle(ParkVehicleDto $parkVehicleDto): void
    {
        $fleet = $this->fleetRepository->find($parkVehicleDto->getFleetId());
        if (!$fleet instanceof Fleet) {
            throw new Exception('Fleet not found.');
        }
        $vehicle = $this->vehicleFactory->create($parkVehicleDto->getType(), $parkVehicleDto->getPlateNumber());
        $location = $this->locationFactory->create($parkVehicleDto->getLatitude(), $parkVehicleDto->getLongitude());
        $fleet->parkVehicle($vehicle, $location);
        $this->fleetRepository->save($fleet);
    }
}
