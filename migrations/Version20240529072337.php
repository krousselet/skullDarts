<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240529072337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detail (id INT AUTO_INCREMENT NOT NULL, date DATE DEFAULT NULL, prix INT DEFAULT NULL, activite0 VARCHAR(100) DEFAULT NULL, activite1 VARCHAR(100) DEFAULT NULL, activite2 VARCHAR(100) DEFAULT NULL, heure VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE publication ADD detail_id INT DEFAULT NULL, ADD paragraphe1 LONGTEXT NOT NULL, ADD paragraphe2 LONGTEXT NOT NULL, ADD paragraphe3 LONGTEXT NOT NULL, ADD paragraphe4 LONGTEXT NOT NULL, ADD paragraphe5 LONGTEXT NOT NULL, CHANGE contenu paragraphe0 LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779D8D003BB FOREIGN KEY (detail_id) REFERENCES detail (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF3C6779D8D003BB ON publication (detail_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779D8D003BB');
        $this->addSql('DROP TABLE detail');
        $this->addSql('DROP INDEX UNIQ_AF3C6779D8D003BB ON publication');
        $this->addSql('ALTER TABLE publication ADD contenu LONGTEXT NOT NULL, DROP detail_id, DROP paragraphe0, DROP paragraphe1, DROP paragraphe2, DROP paragraphe3, DROP paragraphe4, DROP paragraphe5');
    }
}
