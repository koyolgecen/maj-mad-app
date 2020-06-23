<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623132345 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE devis DROP FOREIGN KEY FK_8B27C52BD5E86FF');
        $this->addSql('DROP TABLE etat_devis');
        $this->addSql('DROP INDEX IDX_8B27C52BD5E86FF ON devis');
        $this->addSql('ALTER TABLE devis ADD etat VARCHAR(50) NOT NULL, DROP etat_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE etat_devis (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, commendable TINYINT(1) DEFAULT \'0\' NOT NULL, badge_style VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE devis ADD etat_id INT NOT NULL, DROP etat');
        $this->addSql('ALTER TABLE devis ADD CONSTRAINT FK_8B27C52BD5E86FF FOREIGN KEY (etat_id) REFERENCES etat_devis (id)');
        $this->addSql('CREATE INDEX IDX_8B27C52BD5E86FF ON devis (etat_id)');
    }
}
