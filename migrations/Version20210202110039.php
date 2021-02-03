<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202110039 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE outing ADD statut_etat_id INT NOT NULL');
        $this->addSql('ALTER TABLE outing ADD CONSTRAINT FK_F2A1062561EF9CB3 FOREIGN KEY (statut_etat_id) REFERENCES etat (id)');
        $this->addSql('CREATE INDEX IDX_F2A1062561EF9CB3 ON outing (statut_etat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outing DROP FOREIGN KEY FK_F2A1062561EF9CB3');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP INDEX IDX_F2A1062561EF9CB3 ON outing');
        $this->addSql('ALTER TABLE outing DROP statut_etat_id');
    }
}
