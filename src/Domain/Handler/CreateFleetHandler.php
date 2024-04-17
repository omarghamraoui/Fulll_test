<?php

declare(strict_types=1);

namespace App\Domain\Handler;

use App\Domain\Command\CreateFleetCommand;
use App\Domain\Factory\FleetFactory;
use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\Service\FleetService;

final class CreateFleetHandler
{
    public function __construct(
        private readonly FleetRepositoryInterface $fleetRepository,
        private readonly FleetService $fleetService
    ) {
    }

    public function handle(CreateFleetCommand $command): Fleet
    {
        $fleet = $this->fleetRepository->findFleetById($command->fleetId());
        if (null === $fleet) {
            $fleet = $this->fleetService->createFleet($command->fleetId());
        }
        return $fleet;
    }
}
