<?php

namespace App\Infra\Repository;

use App\Domain\Model\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;

class FleetRepository implements FleetRepositoryInterface
{
    private $fleets = [];

    public function find(string $id) : ?Fleet
    {
        return $this->fleets[$id] ?? null;
    }

    public function save(Fleet $fleet, bool $flush = false) : void
    {
        $this->fleets[$fleet->getId()] = $fleet;
    }
}
