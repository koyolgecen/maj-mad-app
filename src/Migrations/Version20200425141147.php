<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200425141147 extends AbstractMigration
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
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426282550A73F');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426283C78F64D');
        $this->addSql('DROP INDEX IDX_C2426282550A73F ON module');
        $this->addSql('DROP INDEX IDX_C2426283C78F64D ON module');
        $this->addSql('ALTER TABLE module ADD coupe_de_principe_id INT DEFAULT NULL, ADD cctp_id INT DEFAULT NULL, DROP coupe_de_principe_id_id, DROP cctp_id_id');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426287FB6BB5E FOREIGN KEY (coupe_de_principe_id) REFERENCES coupe_de_principe (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628573F0E43 FOREIGN KEY (cctp_id) REFERENCES cctp (id)');
        $this->addSql('CREATE INDEX IDX_C2426287FB6BB5E ON module (coupe_de_principe_id)');
        $this->addSql('CREATE INDEX IDX_C242628573F0E43 ON module (cctp_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE composant CHANGE marge_id marge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C2426287FB6BB5E');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628573F0E43');
        $this->addSql('DROP INDEX IDX_C2426287FB6BB5E ON module');
        $this->addSql('DROP INDEX IDX_C242628573F0E43 ON module');
        $this->addSql('ALTER TABLE module ADD coupe_de_principe_id_id INT DEFAULT NULL, ADD cctp_id_id INT DEFAULT NULL, DROP coupe_de_principe_id, DROP cctp_id');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426282550A73F FOREIGN KEY (coupe_de_principe_id_id) REFERENCES coupe_de_principe (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C2426283C78F64D FOREIGN KEY (cctp_id_id) REFERENCES cctp (id)');
        $this->addSql('CREATE INDEX IDX_C2426282550A73F ON module (coupe_de_principe_id_id)');
        $this->addSql('CREATE INDEX IDX_C2426283C78F64D ON module (cctp_id_id)');
    }
}
