<?php

declare(strict_types=1);

namespace App\Tests\Service;

use Doctrine\ORM\EntityManagerInterface;

class DatabaseCleaner
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function cleanDatabase()
    {
        $connection = $this->entityManager->getConnection();
        $platform   = $connection->getDatabasePlatform();

        $connection->executeQuery('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->entityManager->getMetadataFactory()->getAllMetadata() as $metadata) {
            $connection->executeStatement($platform->getTruncateTableSQL($metadata->getTableName()));
        }
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }
}
