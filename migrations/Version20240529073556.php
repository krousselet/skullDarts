<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240529073556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail ADD publication_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F9338B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2E067F9338B217A7 ON detail (publication_id)');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779D8D003BB');
        $this->addSql('DROP INDEX UNIQ_AF3C6779D8D003BB ON publication');
        $this->addSql('ALTER TABLE publication DROP detail_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F9338B217A7');
        $this->addSql('DROP INDEX UNIQ_2E067F9338B217A7 ON detail');
        $this->addSql('ALTER TABLE detail DROP publication_id');
        $this->addSql('ALTER TABLE publication ADD detail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779D8D003BB FOREIGN KEY (detail_id) REFERENCES detail (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF3C6779D8D003BB ON publication (detail_id)');
    }
}
