<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915001320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD google_form_link VARCHAR(255) DEFAULT NULL, ADD google_map_link VARCHAR(255) DEFAULT NULL, DROP lat, DROP lng');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD lat VARCHAR(255) DEFAULT NULL, ADD lng VARCHAR(255) DEFAULT NULL, DROP google_form_link, DROP google_map_link');
    }
}
