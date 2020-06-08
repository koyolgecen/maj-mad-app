<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200607105048 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE paiement_echelonne (id INT AUTO_INCREMENT NOT NULL, nom_etape VARCHAR(50) NOT NULL, pourcentage_apayer DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE devis ADD paiement_echelonne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52B13DEA3E1 FOREIGN KEY (paiement_echelonne_id) REFERENCES paiement_echelonne (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52B13DEA3E1 ON devis (paiement_echelonne_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52B13DEA3E1');
        $this->addSql('DROP TABLE paiement_echelonne');
        $this->addSql('DROP INDEX IDX_8B27C52B13DEA3E1 ON devis');
        $this->addSql('ALTER TABLE devis DROP paiement_echelonne_id');
    }
}
