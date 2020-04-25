<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425143152 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composant CHANGE marge_id marge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628573F0E43');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426287FB6BB5E');
        $this->addSql('DROP INDEX IDX_C2426287FB6BB5E ON module');
        $this->addSql('DROP INDEX IDX_C242628573F0E43 ON module');
        $this->addSql('ALTER TABLE module ADD coupeDePrincipe_id VARCHAR(255) NOT NULL, DROP coupe_de_principe_id, CHANGE cctp_id cctp_id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composant CHANGE marge_id marge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD coupe_de_principe_id INT DEFAULT NULL, DROP coupeDePrincipe_id, CHANGE cctp_id cctp_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628573F0E43 FOREIGN KEY (cctp_id) REFERENCES cctp (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426287FB6BB5E FOREIGN KEY (coupe_de_principe_id) REFERENCES coupe_de_principe (id)');
        $this->addSql('CREATE INDEX IDX_C2426287FB6BB5E ON module (coupe_de_principe_id)');
        $this->addSql('CREATE INDEX IDX_C242628573F0E43 ON module (cctp_id)');
    }
}
