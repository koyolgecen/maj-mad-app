<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200510165941 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gamme (id INT AUTO_INCREMENT NOT NULL, isolant_id INT NOT NULL, couverture_id INT NOT NULL, qualitehuisserie_id INT NOT NULL, finition_exterieur_id INT NOT NULL, mode_conception_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_C32E1468DA7C1260 (isolant_id), INDEX IDX_C32E14683F0A9AF5 (couverture_id), INDEX IDX_C32E14681F53BB0A (qualitehuisserie_id), INDEX IDX_C32E1468B33D6EF3 (finition_exterieur_id), INDEX IDX_C32E14682E242DD5 (mode_conception_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E1468DA7C1260 FOREIGN KEY (isolant_id) REFERENCES isolant_gamme (id)');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E14683F0A9AF5 FOREIGN KEY (couverture_id) REFERENCES couverture_gamme (id)');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E14681F53BB0A FOREIGN KEY (qualitehuisserie_id) REFERENCES qualite_huisserie_gamme (id)');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E1468B33D6EF3 FOREIGN KEY (finition_exterieur_id) REFERENCES finition_exterieur_gamme (id)');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E14682E242DD5 FOREIGN KEY (mode_conception_id) REFERENCES mode_conception (id)');
        $this->addSql('ALTER TABLE mode_conception ADD regle_calcul_id INT NOT NULL');
        $this->addSql('ALTER TABLE mode_conception ADD CONSTRAINT FK_AABD1A672428EEA9 FOREIGN KEY (regle_calcul_id) REFERENCES regle_calcul (id)');
        $this->addSql('CREATE INDEX IDX_AABD1A672428EEA9 ON mode_conception (regle_calcul_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE gamme');
        $this->addSql('ALTER TABLE mode_conception DROP FOREIGN KEY FK_AABD1A672428EEA9');
        $this->addSql('DROP INDEX IDX_AABD1A672428EEA9 ON mode_conception');
        $this->addSql('ALTER TABLE mode_conception DROP regle_calcul_id');
    }
}
