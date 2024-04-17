<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417103229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fleet (id INT AUTO_INCREMENT NOT NULL, fleet_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A05E1E474B061DF9 (fleet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, fleet_id INT NOT NULL, plate_number VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1B80E48664D218E (location_id), INDEX IDX_1B80E4864B061DF9 (fleet_id), UNIQUE INDEX fleet_vehicle (fleet_id, plate_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48664D218E FOREIGN KEY (location_id) REFERENCES location (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4864B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48664D218E');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4864B061DF9');
        $this->addSql('DROP TABLE fleet');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE vehicle');
    }
}
