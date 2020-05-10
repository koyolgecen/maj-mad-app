<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510134816 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, adresse VARCHAR(50) NOT NULL, ville VARCHAR(50) NOT NULL, code_postale INT NOT NULL, telephone INT NOT NULL, mail VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele_arealiser (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_5DFE6A35C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_arealiser (id INT AUTO_INCREMENT NOT NULL, modele_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, mode_conception VARCHAR(50) NOT NULL, longueur DOUBLE PRECISION NOT NULL, largeur DOUBLE PRECISION NOT NULL, INDEX IDX_E9F9CCEFAC14B70A (modele_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, type VARCHAR(50) NOT NULL, date_creation DATE NOT NULL, reference VARCHAR(50) NOT NULL, INDEX IDX_50159CA919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet_produit (projet_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_AB8FB156C18272 (projet_id), INDEX IDX_AB8FB156F347EFB (produit_id), PRIMARY KEY(projet_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE modele_arealiser ADD CONSTRAINT FK_5DFE6A35C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE module_arealiser ADD CONSTRAINT FK_E9F9CCEFAC14B70A FOREIGN KEY (modele_id) REFERENCES modele_arealiser (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE projet_produit ADD CONSTRAINT FK_AB8FB156C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet_produit ADD CONSTRAINT FK_AB8FB156F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA919EB6921');
        $this->addSql('ALTER TABLE module_arealiser DROP FOREIGN KEY FK_E9F9CCEFAC14B70A');
        $this->addSql('ALTER TABLE projet_produit DROP FOREIGN KEY FK_AB8FB156F347EFB');
        $this->addSql('ALTER TABLE modele_arealiser DROP FOREIGN KEY FK_5DFE6A35C18272');
        $this->addSql('ALTER TABLE projet_produit DROP FOREIGN KEY FK_AB8FB156C18272');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE modele_arealiser');
        $this->addSql('DROP TABLE module_arealiser');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE projet_produit');
    }
}
