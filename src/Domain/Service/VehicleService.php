<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\App\Dto\AddVehicleDto;
use App\Domain\Factory\VehicleFactory;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\Repository\VehicleRepositoryInterface;
use Exception;
use Symfony\Component\Config\Definition\Exception\DuplicateKeyException;

final class VehicleService
{
    public function __construct(
        private readonly FleetRepositoryInterface $fleetRepository,
        private readonly VehicleFactory $vehicleFactory,
        private readonly VehicleRepositoryInterface $vehicleRepository
    ) {
    }

    /**
     * @throws Exception
     */
    public function register(AddVehicleDto $addVehicleDto): Vehicle
    {
        $fleet = $this->fleetRepository->findFleetById($addVehicleDto->fleetId())
            ?? throw new Exception('Fleet not found.');
        $existVehicle = $this->vehicleRepository->findVehicleByPlateNumberAndFleet(
            $addVehicleDto->plateNumber(),
            $fleet
        );
        if (null !== $existVehicle) {
            throw new DuplicateKeyException('Vehicle already registered with same fleet');
        }
        $vehicle = $this->vehicleFactory->create($addVehicleDto->plateNumber(), null, $fleet);
        $fleet->addVehicle($vehicle);
        $this->fleetRepository->save($fleet, true);
        $this->vehicleRepository->save($vehicle, true);
        return $vehicle;
    }
}
