<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250805141520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, maker_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, top_speed INT DEFAULT NULL, engine_type VARCHAR(255) DEFAULT NULL, engine_power INT DEFAULT NULL, fuel_type VARCHAR(255) DEFAULT NULL, length NUMERIC(10, 2) DEFAULT NULL, width NUMERIC(10, 2) DEFAULT NULL, height NUMERIC(10, 2) DEFAULT NULL, weight NUMERIC(10, 2) DEFAULT NULL, number_of_seats INT DEFAULT NULL, zero_to_hundred_time NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_1B80E48668DA5EC3 (maker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_maker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48668DA5EC3 FOREIGN KEY (maker_id) REFERENCES vehicle_maker (id) ON DELETE CASCADE;');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48668DA5EC3');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE vehicle_maker');
    }
}
