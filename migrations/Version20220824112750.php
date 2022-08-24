<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * class Version20220824112750.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class Version20220824112750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add event management tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE committee_member (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, job_title VARCHAR(255) NOT NULL, organization VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, avatar_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, event_starts_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', event_ends_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', registration_starts_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', registration_ends_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', description LONGTEXT NOT NULL, location VARCHAR(255) NOT NULL, lat VARCHAR(255) DEFAULT NULL, lng VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, thumbnail_url VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_online TINYINT(1) NOT NULL, INDEX IDX_5A8A6C8DF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pricing (id INT AUTO_INCREMENT NOT NULL, student DOUBLE PRECISION NOT NULL, academic DOUBLE PRECISION NOT NULL, professional DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE speaker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, job_title VARCHAR(255) NOT NULL, organization VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', avatar_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE talk (id INT AUTO_INCREMENT NOT NULL, speaker_id INT NOT NULL, event_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, schedule_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9F24D5BBD04A0F27 (speaker_id), INDEX IDX_9F24D5BB71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE talk ADD CONSTRAINT FK_9F24D5BBD04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id)');
        $this->addSql('ALTER TABLE talk ADD CONSTRAINT FK_9F24D5BB71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE talk DROP FOREIGN KEY FK_9F24D5BBD04A0F27');
        $this->addSql('ALTER TABLE talk DROP FOREIGN KEY FK_9F24D5BB71F7E88B');
        $this->addSql('DROP TABLE committee_member');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE pricing');
        $this->addSql('DROP TABLE speaker');
        $this->addSql('DROP TABLE talk');
    }
}
