<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517203654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE nature ADD caracteristique_nature_id INT DEFAULT NULL, ADD unite_nature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nature ADD CONSTRAINT FK_B1D882A7151DBE1F FOREIGN KEY (caracteristique_nature_id) REFERENCES caracteristique_nature (id)');
        $this->addSql('ALTER TABLE nature ADD CONSTRAINT FK_B1D882A7BF3A0A0E FOREIGN KEY (unite_nature_id) REFERENCES unite_nature (id)');
        $this->addSql('CREATE INDEX IDX_B1D882A7151DBE1F ON nature (caracteristique_nature_id)');
        $this->addSql('CREATE INDEX IDX_B1D882A7BF3A0A0E ON nature (unite_nature_id)');
        $this->addSql('ALTER TABLE caracteristique_nature DROP FOREIGN KEY FK_A671B84D644EE13');
        $this->addSql('DROP INDEX IDX_A671B84D644EE13 ON caracteristique_nature');
        $this->addSql('ALTER TABLE caracteristique_nature DROP natures_id, CHANGE desc_carac_nature desc_carac_nature VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE unite_nature DROP FOREIGN KEY FK_8AF2453644EE13');
        $this->addSql('DROP INDEX IDX_8AF2453644EE13 ON unite_nature');
        $this->addSql('ALTER TABLE unite_nature DROP natures_id, CHANGE desc_unite_nature desc_unite_nature VARCHAR(1000) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE caracteristique_nature ADD natures_id INT DEFAULT NULL, CHANGE desc_carac_nature desc_carac_nature VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE caracteristique_nature ADD CONSTRAINT FK_A671B84D644EE13 FOREIGN KEY (natures_id) REFERENCES nature (id)');
        $this->addSql('CREATE INDEX IDX_A671B84D644EE13 ON caracteristique_nature (natures_id)');
        $this->addSql('ALTER TABLE nature DROP FOREIGN KEY FK_B1D882A7151DBE1F');
        $this->addSql('ALTER TABLE nature DROP FOREIGN KEY FK_B1D882A7BF3A0A0E');
        $this->addSql('DROP INDEX IDX_B1D882A7151DBE1F ON nature');
        $this->addSql('DROP INDEX IDX_B1D882A7BF3A0A0E ON nature');
        $this->addSql('ALTER TABLE nature DROP caracteristique_nature_id, DROP unite_nature_id');
        $this->addSql('ALTER TABLE unite_nature ADD natures_id INT DEFAULT NULL, CHANGE desc_unite_nature desc_unite_nature VARCHAR(45) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE unite_nature ADD CONSTRAINT FK_8AF2453644EE13 FOREIGN KEY (natures_id) REFERENCES nature (id)');
        $this->addSql('CREATE INDEX IDX_8AF2453644EE13 ON unite_nature (natures_id)');
    }
}
