<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425212130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, coupe_de_principe_id INT NOT NULL, cctp_id INT NOT NULL, nom VARCHAR(50) NOT NULL, quantite INT NOT NULL, INDEX IDX_C2426287FB6BB5E (coupe_de_principe_id), INDEX IDX_C242628573F0E43 (cctp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_composant (module_id INT NOT NULL, composant_id INT NOT NULL, INDEX IDX_B6E59901AFC2B591 (module_id), INDEX IDX_B6E599017F3310E7 (composant_id), PRIMARY KEY(module_id, composant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cctp (id INT AUTO_INCREMENT NOT NULL, longueur DOUBLE PRECISION NOT NULL, largeur DOUBLE PRECISION NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coupe_de_principe (id INT AUTO_INCREMENT NOT NULL, type_coupe_principe VARCHAR(100) NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426287FB6BB5E FOREIGN KEY (coupe_de_principe_id) REFERENCES coupe_de_principe (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628573F0E43 FOREIGN KEY (cctp_id) REFERENCES cctp (id)');
        $this->addSql('ALTER TABLE module_composant ADD CONSTRAINT FK_B6E59901AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_composant ADD CONSTRAINT FK_B6E599017F3310E7 FOREIGN KEY (composant_id) REFERENCES composant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE module_composant DROP FOREIGN KEY FK_B6E59901AFC2B591');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628573F0E43');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426287FB6BB5E');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_composant');
        $this->addSql('DROP TABLE cctp');
        $this->addSql('DROP TABLE coupe_de_principe');
    }
}
