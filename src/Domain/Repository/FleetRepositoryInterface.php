<?php

namespace App\Domain\Repository;

use App\Domain\Model\Fleet;

interface FleetRepositoryInterface
{
    public function find(string $id) : ?Fleet;

    public function save(Fleet $fleet, bool $flush = false) : void;
}
