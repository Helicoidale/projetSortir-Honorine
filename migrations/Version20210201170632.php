<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201170632 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE outing (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, date_heure_debut DATETIME NOT NULL, duree DATETIME NOT NULL, date_limite_inscription DATE NOT NULL, nb_inscription_max INT NOT NULL, infos_sortie LONGTEXT NOT NULL, etat INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_outing (user_id INT NOT NULL, outing_id INT NOT NULL, INDEX IDX_97F31D18A76ED395 (user_id), INDEX IDX_97F31D18AF4C7531 (outing_id), PRIMARY KEY(user_id, outing_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_outing ADD CONSTRAINT FK_97F31D18A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_outing ADD CONSTRAINT FK_97F31D18AF4C7531 FOREIGN KEY (outing_id) REFERENCES outing (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_outing DROP FOREIGN KEY FK_97F31D18AF4C7531');
        $this->addSql('DROP TABLE outing');
        $this->addSql('DROP TABLE user_outing');
    }
}
