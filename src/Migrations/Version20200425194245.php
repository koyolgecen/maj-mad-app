<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425194245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composant DROP FOREIGN KEY FK_EC8486C9FB0D31D6');
        $this->addSql('ALTER TABLE composant ADD CONSTRAINT FK_EC8486C9FB0D31D6 FOREIGN KEY (marge_id) REFERENCES marge (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composant DROP FOREIGN KEY FK_EC8486C9FB0D31D6');
        $this->addSql('ALTER TABLE composant ADD CONSTRAINT FK_EC8486C9FB0D31D6 FOREIGN KEY (marge_id) REFERENCES marge (id)');
    }
}
