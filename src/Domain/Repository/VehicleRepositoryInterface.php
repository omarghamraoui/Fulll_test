<?php

namespace App\Domain\Repository;

use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;

interface VehicleRepositoryInterface
{
    public function findVehicleByPlateNumber(string $plateNumber): ?Vehicle;
    public function findVehicleByPlateNumberAndFleet(string $plateNumber, Fleet $fleet): ?Vehicle;
    public function save(Vehicle $entity, bool $flush = false): void;
}
