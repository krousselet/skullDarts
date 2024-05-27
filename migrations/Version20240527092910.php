<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240527092910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD publication_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F9A9AD8DB FOREIGN KEY (publication_id_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F9A9AD8DB ON image (publication_id_id)');
        $this->addSql('ALTER TABLE utilisateur ADD is_verified TINYINT(1) NOT NULL, ADD is_agreed TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F9A9AD8DB');
        $this->addSql('DROP INDEX IDX_C53D045F9A9AD8DB ON image');
        $this->addSql('ALTER TABLE image DROP publication_id_id');
        $this->addSql('ALTER TABLE utilisateur DROP is_verified, DROP is_agreed');
    }
}
