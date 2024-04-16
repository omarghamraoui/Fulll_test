<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\App\Dto\AddVehicleDto;
use App\Domain\Factory\VehicleFactory;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use Exception;

final class VehicleService
{
    public function __construct(
        private readonly FleetRepositoryInterface $fleetRepository,
        private readonly VehicleFactory $vehicleFactory
    ) {
    }

    /**
     * @throws Exception
     */
    public function register(AddVehicleDto $registerVehicleDto): Fleet
    {
        $fleet = $this->fleetRepository->find($registerVehicleDto->fleetId())
            ?? throw new Exception('Fleet not found.');
        $vehicle = $this->vehicleFactory->create($registerVehicleDto->type(), $registerVehicleDto->plateNumber());
        $fleet->addVehicle($vehicle);
        $this->fleetRepository->save($fleet);
        return $fleet;
    }
}
