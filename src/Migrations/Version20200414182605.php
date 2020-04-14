<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414182605 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE composant_fournisseur (composant_id INT NOT NULL, fournisseur_id INT NOT NULL, INDEX IDX_996BE157F3310E7 (composant_id), INDEX IDX_996BE15670C757F (fournisseur_id), PRIMARY KEY(composant_id, fournisseur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE composant_fournisseur ADD CONSTRAINT FK_996BE157F3310E7 FOREIGN KEY (composant_id) REFERENCES composant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE composant_fournisseur ADD CONSTRAINT FK_996BE15670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE composant ADD marge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE composant ADD CONSTRAINT FK_EC8486C9FB0D31D6 FOREIGN KEY (marge_id) REFERENCES marge (id)');
        $this->addSql('CREATE INDEX IDX_EC8486C9FB0D31D6 ON composant (marge_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE composant_fournisseur');
        $this->addSql('ALTER TABLE composant DROP FOREIGN KEY FK_EC8486C9FB0D31D6');
        $this->addSql('DROP INDEX IDX_EC8486C9FB0D31D6 ON composant');
        $this->addSql('ALTER TABLE composant DROP marge_id');
    }
}
