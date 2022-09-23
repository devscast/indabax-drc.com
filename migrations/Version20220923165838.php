<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923165838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event_speaker (event_id INT NOT NULL, speaker_id INT NOT NULL, INDEX IDX_FED272CE71F7E88B (event_id), INDEX IDX_FED272CED04A0F27 (speaker_id), PRIMARY KEY(event_id, speaker_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organizer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, organization VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_speaker ADD CONSTRAINT FK_FED272CE71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_speaker ADD CONSTRAINT FK_FED272CED04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE talk DROP FOREIGN KEY FK_9F24D5BB71F7E88B');
        $this->addSql('ALTER TABLE talk DROP FOREIGN KEY FK_9F24D5BBD04A0F27');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE talk');
        $this->addSql('ALTER TABLE event DROP registration_starts_at, DROP registration_ends_at');
        $this->addSql('ALTER TABLE speaker CHANGE avatar_url image VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, thumbnail_url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_online TINYINT(1) NOT NULL, INDEX IDX_5A8A6C8DF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE talk (id INT AUTO_INCREMENT NOT NULL, speaker_id INT NOT NULL, event_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, schedule_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', youtube_replay_url VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_9F24D5BB71F7E88B (event_id), INDEX IDX_9F24D5BBD04A0F27 (speaker_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE talk ADD CONSTRAINT FK_9F24D5BB71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE talk ADD CONSTRAINT FK_9F24D5BBD04A0F27 FOREIGN KEY (speaker_id) REFERENCES speaker (id)');
        $this->addSql('ALTER TABLE event_speaker DROP FOREIGN KEY FK_FED272CE71F7E88B');
        $this->addSql('ALTER TABLE event_speaker DROP FOREIGN KEY FK_FED272CED04A0F27');
        $this->addSql('DROP TABLE event_speaker');
        $this->addSql('DROP TABLE organizer');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('ALTER TABLE event ADD registration_starts_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD registration_ends_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE speaker CHANGE image avatar_url VARCHAR(255) NOT NULL');
    }
}
