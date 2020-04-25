<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425151958 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE caracteristique_nature (id INT AUTO_INCREMENT NOT NULL, natures_id INT DEFAULT NULL, desc_carac_nature VARCHAR(45) NOT NULL, nom_carac_nature VARCHAR(45) NOT NULL, INDEX IDX_A671B84D644EE13 (natures_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nature (id INT AUTO_INCREMENT NOT NULL, nom_nature VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unite_nature (id INT AUTO_INCREMENT NOT NULL, natures_id INT DEFAULT NULL, desc_unite_nature VARCHAR(45) NOT NULL, unite_usage_nature VARCHAR(45) NOT NULL, INDEX IDX_8AF2453644EE13 (natures_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caracteristique_nature ADD CONSTRAINT FK_A671B84D644EE13 FOREIGN KEY (natures_id) REFERENCES nature (id)');
        $this->addSql('ALTER TABLE unite_nature ADD CONSTRAINT FK_8AF2453644EE13 FOREIGN KEY (natures_id) REFERENCES nature (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE caracteristique_nature DROP FOREIGN KEY FK_A671B84D644EE13');
        $this->addSql('ALTER TABLE unite_nature DROP FOREIGN KEY FK_8AF2453644EE13');
        $this->addSql('DROP TABLE caracteristique_nature');
        $this->addSql('DROP TABLE nature');
        $this->addSql('DROP TABLE unite_nature');
    }
}
