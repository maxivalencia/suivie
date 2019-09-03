<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829064757 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE unite_id unite_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE unites CHANGE unitesuperieur_id unitesuperieur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dossiers CHANGE resultat_id resultat_id INT DEFAULT NULL, CHANGE typedossier_id typedossier_id INT DEFAULT NULL, CHANGE traitement_id traitement_id INT DEFAULT NULL, CHANGE uniteorigine_id uniteorigine_id INT DEFAULT NULL, CHANGE unitedestinataire_id unitedestinataire_id INT DEFAULT NULL, CHANGE precdossiers_id precdossiers_id INT DEFAULT NULL, CHANGE daterecepnumeric daterecepnumeric DATETIME DEFAULT NULL, CHANGE daterecepeffectif daterecepeffectif DATETIME DEFAULT NULL, CHANGE dureetraitement dureetraitement INT DEFAULT NULL, CHANGE dureeeffectif dureeeffectif INT DEFAULT NULL, CHANGE suggestions suggestions VARCHAR(255) DEFAULT NULL, CHANGE piecejointes piecejointes VARCHAR(255) DEFAULT NULL, CHANGE montant montant INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dossiers CHANGE resultat_id resultat_id INT DEFAULT NULL, CHANGE typedossier_id typedossier_id INT DEFAULT NULL, CHANGE traitement_id traitement_id INT DEFAULT NULL, CHANGE uniteorigine_id uniteorigine_id INT DEFAULT NULL, CHANGE unitedestinataire_id unitedestinataire_id INT DEFAULT NULL, CHANGE precdossiers_id precdossiers_id INT DEFAULT NULL, CHANGE daterecepnumeric daterecepnumeric DATETIME DEFAULT \'NULL\', CHANGE daterecepeffectif daterecepeffectif DATETIME DEFAULT \'NULL\', CHANGE dureetraitement dureetraitement INT DEFAULT NULL, CHANGE dureeeffectif dureeeffectif INT DEFAULT NULL, CHANGE suggestions suggestions VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE piecejointes piecejointes VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE montant montant INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unites CHANGE unitesuperieur_id unitesuperieur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE unite_id unite_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
