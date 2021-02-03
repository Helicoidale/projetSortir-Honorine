<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203152028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outing CHANGE organisateur_id organisateur_id INT DEFAULT NULL, CHANGE campus_id campus_id INT DEFAULT NULL, CHANGE duree duree DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) NOT NULL, CHANGE campus_id campus_id INT DEFAULT NULL, CHANGE mot_de_passe mot_de_passe VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6495126AC48 ON user (mail)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986CC499D ON user (pseudo)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outing CHANGE organisateur_id organisateur_id INT NOT NULL, CHANGE campus_id campus_id INT NOT NULL, CHANGE duree duree DATETIME NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D6495126AC48 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D64986CC499D ON user');
        $this->addSql('ALTER TABLE user DROP role, CHANGE campus_id campus_id INT NOT NULL, CHANGE mot_de_passe mot_de_passe VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
