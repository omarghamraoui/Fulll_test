<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\App\Dto\ParkVehicleDto;
use App\Domain\Factory\LocationFactory;
use App\Domain\Factory\VehicleFactory;
use App\Domain\Handler\LocalizeVehicleHandler;
use App\Domain\Model\Fleet;
use App\Domain\Model\Location;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\Repository\LocationRepositoryInterface;
use App\Domain\Repository\VehicleRepositoryInterface;
use Exception;

final class ParkVehicleService
{
    public function __construct(
        private readonly FleetRepositoryInterface $fleetRepository,
        private readonly VehicleRepositoryInterface $vehicleRepository,
        private readonly LocationRepositoryInterface $locationRepository,
        private readonly LocationFactory $locationFactory
    ) {
    }

    public function parkVehicle(ParkVehicleDto $parkVehicleDto): void
    {
        $fleet = $this->fleetRepository->findFleetById($parkVehicleDto->fleetId());
        if (!$fleet instanceof Fleet) {
            throw new Exception('Fleet not found.');
        }
        $vehicle = $this->vehicleRepository->findVehicleByPlateNumber($parkVehicleDto->getPlateNumber());
        $location = $this->locationRepository->findLocationByLatLngVehicle(
            $parkVehicleDto->getLatitude(),
            $parkVehicleDto->getLongitude(),
            $vehicle
        );
        if (null === $location) {
            $location = $this->locationFactory->create($parkVehicleDto->getLatitude(), $parkVehicleDto->getLongitude());
        }
        $fleet->isAlreadyParked($parkVehicleDto->getPlateNumber(), $location);
        if (null !== $vehicle) {
            $vehicle->parkAt($location);
            $this->fleetRepository->save($fleet, true);
            $this->locationRepository->save($location, true);
            $this->vehicleRepository->save($vehicle, true);
        }
    }
}
