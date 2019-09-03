<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190517075707 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dossiers (id INT AUTO_INCREMENT NOT NULL, resultat_id INT DEFAULT NULL, typedossier_id INT DEFAULT NULL, traitement_id INT DEFAULT NULL, uniteorigine_id INT DEFAULT NULL, unitedestinataire_id INT DEFAULT NULL, precdossiers_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, objet VARCHAR(255) NOT NULL, dateexpedition DATETIME NOT NULL, daterecepnumeric DATETIME DEFAULT NULL, daterecepeffectif DATETIME DEFAULT NULL, referencesuivie VARCHAR(255) NOT NULL, dureetraitement INT DEFAULT NULL, dureeeffectif INT DEFAULT NULL, suggestions VARCHAR(255) DEFAULT NULL, piecejointes VARCHAR(255) DEFAULT NULL, INDEX IDX_A38E22E4D233E95C (resultat_id), INDEX IDX_A38E22E49846EC5B (typedossier_id), INDEX IDX_A38E22E4DDA344B6 (traitement_id), INDEX IDX_A38E22E4C9EA1CD6 (uniteorigine_id), INDEX IDX_A38E22E42C2BB919 (unitedestinataire_id), INDEX IDX_A38E22E498019D12 (precdossiers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E4D233E95C FOREIGN KEY (resultat_id) REFERENCES resultats (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E49846EC5B FOREIGN KEY (typedossier_id) REFERENCES type_dossiers (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E4DDA344B6 FOREIGN KEY (traitement_id) REFERENCES traitements (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E4C9EA1CD6 FOREIGN KEY (uniteorigine_id) REFERENCES unites (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E42C2BB919 FOREIGN KEY (unitedestinataire_id) REFERENCES unites (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E498019D12 FOREIGN KEY (precdossiers_id) REFERENCES dossiers (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dossiers DROP FOREIGN KEY FK_A38E22E498019D12');
        $this->addSql('DROP TABLE dossiers');
    }
}
