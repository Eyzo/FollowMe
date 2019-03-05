<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305132209 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fm_user ADD profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fm_user ADD CONSTRAINT FK_D7F4EB6ACCFA12B8 FOREIGN KEY (profile_id) REFERENCES fm_profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7F4EB6ACCFA12B8 ON fm_user (profile_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fm_user DROP FOREIGN KEY FK_D7F4EB6ACCFA12B8');
        $this->addSql('DROP INDEX UNIQ_D7F4EB6ACCFA12B8 ON fm_user');
        $this->addSql('ALTER TABLE fm_user DROP profile_id');
    }
}
