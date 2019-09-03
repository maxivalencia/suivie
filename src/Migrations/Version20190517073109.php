<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190517073109 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE unites (id INT AUTO_INCREMENT NOT NULL, commune_id INT NOT NULL, unitesuperieur_id INT DEFAULT NULL, unite VARCHAR(255) NOT NULL, abreviation VARCHAR(64) NOT NULL, localite VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, INDEX IDX_87F339C131A4F72 (commune_id), INDEX IDX_87F339C691F598F (unitesuperieur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, unite_id INT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role JSON NOT NULL COMMENT \'(DC2Type:json_array)\', UNIQUE INDEX UNIQ_1483A5E9EC4A74AB (unite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE unites ADD CONSTRAINT FK_87F339C131A4F72 FOREIGN KEY (commune_id) REFERENCES communes (id)');
        $this->addSql('ALTER TABLE unites ADD CONSTRAINT FK_87F339C691F598F FOREIGN KEY (unitesuperieur_id) REFERENCES unites (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9EC4A74AB FOREIGN KEY (unite_id) REFERENCES unites (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE unites DROP FOREIGN KEY FK_87F339C691F598F');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9EC4A74AB');
        $this->addSql('DROP TABLE unites');
        $this->addSql('DROP TABLE users');
    }
}
