<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305133726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fm_profile ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fm_profile ADD CONSTRAINT FK_262EEA9A76ED395 FOREIGN KEY (user_id) REFERENCES fm_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_262EEA9A76ED395 ON fm_profile (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fm_profile DROP FOREIGN KEY FK_262EEA9A76ED395');
        $this->addSql('DROP INDEX UNIQ_262EEA9A76ED395 ON fm_profile');
        $this->addSql('ALTER TABLE fm_profile DROP user_id');
    }
}
