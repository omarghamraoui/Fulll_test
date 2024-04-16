<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Factory\FleetFactory;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use Exception;

final class FleetService
{
    public function __construct(
        private readonly FleetRepositoryInterface $fleetRepository,
        private readonly FleetFactory $fleetFactory
    ) {
    }

    public function createFleet(string $fleetId): Fleet
    {
        $fleet = $this->fleetRepository->find($fleetId);
        if ($fleet instanceof Fleet) {
            throw new Exception('Fleet already exist');
        }
        $fleet = $this->fleetFactory->create($fleetId);
        $this->fleetRepository->save($fleet);
        return $fleet;
    }
}
