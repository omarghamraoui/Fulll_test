<?php

namespace App\Domain\Model;

use Exception;

final class Fleet
{
    private array $vehicles = [];

    public function __construct(private readonly string $id)
    {
    }

    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @throws Exception
     */
    public function addVehicle(Vehicle $vehicle) : void
    {
        if (true === $this->has($vehicle->plateNumber())) {
            throw new Exception('Vehicle already registered');
        }

        $this->vehicles[$vehicle->plateNumber()] = $vehicle;
    }

    public function has(string $plateNumber) : bool
    {
        return isset($this->vehicles[$plateNumber]);
    }

    /**
     * @throws Exception
     */
    public function parkVehicle(Vehicle $vehicle, Location $location): void
    {
        $this->isAlreadyParked($vehicle->plateNumber(), $location);

        $this->vehicles[$vehicle->plateNumber()] = $vehicle->parkAt($location);
    }

    /**
     * @throws Exception
     */
    public function isAlreadyParked(string $plateNumber, Location $location) : bool
    {
        $vehicle = $this->find($plateNumber);
        if ($vehicle === null) {
            throw new Exception('Vehicle not found');
        }
        $bool = $vehicle->checkLocation($location);
        if ($bool) {
            throw new Exception('Vehicle Already parked');
        }

        return $bool;
    }

    public function find(string $plateNumber) : ?Vehicle
    {
        return $this->vehicles[$plateNumber] ?? null;
    }
}
