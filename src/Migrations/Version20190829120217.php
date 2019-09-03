<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829120217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE unite_id unite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EC4A74AB FOREIGN KEY (unite_id) REFERENCES unites (id)');
        $this->addSql('ALTER TABLE unites CHANGE unitesuperieur_id unitesuperieur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dossiers CHANGE resultat_id resultat_id INT DEFAULT NULL, CHANGE typedossier_id typedossier_id INT DEFAULT NULL, CHANGE traitement_id traitement_id INT DEFAULT NULL, CHANGE uniteorigine_id uniteorigine_id INT DEFAULT NULL, CHANGE unitedestinataire_id unitedestinataire_id INT DEFAULT NULL, CHANGE precdossiers_id precdossiers_id INT DEFAULT NULL, CHANGE daterecepnumeric daterecepnumeric DATETIME DEFAULT NULL, CHANGE daterecepeffectif daterecepeffectif DATETIME DEFAULT NULL, CHANGE dureetraitement dureetraitement INT DEFAULT NULL, CHANGE dureeeffectif dureeeffectif INT DEFAULT NULL, CHANGE suggestions suggestions VARCHAR(255) DEFAULT NULL, CHANGE piecejointes piecejointes VARCHAR(255) DEFAULT NULL, CHANGE montant montant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E4D233E95C FOREIGN KEY (resultat_id) REFERENCES resultats (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E49846EC5B FOREIGN KEY (typedossier_id) REFERENCES type_dossiers (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E4DDA344B6 FOREIGN KEY (traitement_id) REFERENCES traitements (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E4C9EA1CD6 FOREIGN KEY (uniteorigine_id) REFERENCES unites (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E42C2BB919 FOREIGN KEY (unitedestinataire_id) REFERENCES unites (id)');
        $this->addSql('ALTER TABLE dossiers ADD CONSTRAINT FK_A38E22E498019D12 FOREIGN KEY (precdossiers_id) REFERENCES dossiers (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9EC4A74AB FOREIGN KEY (unite_id) REFERENCES unites (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dossiers DROP FOREIGN KEY FK_A38E22E4D233E95C');
        $this->addSql('ALTER TABLE dossiers DROP FOREIGN KEY FK_A38E22E49846EC5B');
        $this->addSql('ALTER TABLE dossiers DROP FOREIGN KEY FK_A38E22E4DDA344B6');
        $this->addSql('ALTER TABLE dossiers DROP FOREIGN KEY FK_A38E22E4C9EA1CD6');
        $this->addSql('ALTER TABLE dossiers DROP FOREIGN KEY FK_A38E22E42C2BB919');
        $this->addSql('ALTER TABLE dossiers DROP FOREIGN KEY FK_A38E22E498019D12');
        $this->addSql('ALTER TABLE dossiers CHANGE resultat_id resultat_id INT DEFAULT NULL, CHANGE typedossier_id typedossier_id INT DEFAULT NULL, CHANGE traitement_id traitement_id INT DEFAULT NULL, CHANGE uniteorigine_id uniteorigine_id INT DEFAULT NULL, CHANGE unitedestinataire_id unitedestinataire_id INT DEFAULT NULL, CHANGE precdossiers_id precdossiers_id INT DEFAULT NULL, CHANGE daterecepnumeric daterecepnumeric DATETIME DEFAULT \'NULL\', CHANGE daterecepeffectif daterecepeffectif DATETIME DEFAULT \'NULL\', CHANGE dureetraitement dureetraitement INT DEFAULT NULL, CHANGE dureeeffectif dureeeffectif INT DEFAULT NULL, CHANGE suggestions suggestions VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE piecejointes piecejointes VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE montant montant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unites CHANGE unitesuperieur_id unitesuperieur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EC4A74AB');
        $this->addSql('ALTER TABLE user CHANGE unite_id unite_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9EC4A74AB');
    }
}
