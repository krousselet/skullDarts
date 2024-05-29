<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240528120922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7B981C689');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7FAC8564B');
        $this->addSql('DROP INDEX IDX_5FB6DEC7FAC8564B ON reponse');
        $this->addSql('DROP INDEX IDX_5FB6DEC7B981C689 ON reponse');
        $this->addSql('ALTER TABLE reponse ADD commentaire_id INT DEFAULT NULL, ADD utilisateur_id INT DEFAULT NULL, DROP commentaire_id_id, DROP utilisateur_id_id');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7BA9CD190 ON reponse (commentaire_id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7FB88E14F ON reponse (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7BA9CD190');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7FB88E14F');
        $this->addSql('DROP INDEX IDX_5FB6DEC7BA9CD190 ON reponse');
        $this->addSql('DROP INDEX IDX_5FB6DEC7FB88E14F ON reponse');
        $this->addSql('ALTER TABLE reponse ADD commentaire_id_id INT DEFAULT NULL, ADD utilisateur_id_id INT DEFAULT NULL, DROP commentaire_id, DROP utilisateur_id');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7B981C689 FOREIGN KEY (utilisateur_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FAC8564B FOREIGN KEY (commentaire_id_id) REFERENCES commentaire (id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7FAC8564B ON reponse (commentaire_id_id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7B981C689 ON reponse (utilisateur_id_id)');
    }
}
