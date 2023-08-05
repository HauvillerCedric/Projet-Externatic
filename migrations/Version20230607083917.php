<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607083917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mailer (id INT AUTO_INCREMENT NOT NULL, subject_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_98E6E523EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mailer ADD CONSTRAINT FK_98E6E523EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C153C674EE');
        $this->addSql('DROP INDEX IDX_64C19C153C674EE ON category');
        $this->addSql('ALTER TABLE category DROP offer_id');
        $this->addSql('ALTER TABLE company ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE offer ADD slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE profil ADD title_profil VARCHAR(255) NOT NULL, ADD location_profil VARCHAR(255) NOT NULL, DROP title, DROP location, CHANGE description description_profil LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mailer DROP FOREIGN KEY FK_98E6E523EDC87');
        $this->addSql('DROP TABLE mailer');
        $this->addSql('DROP TABLE subject');
        $this->addSql('ALTER TABLE category ADD offer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C153C674EE FOREIGN KEY (offer_id) REFERENCES offer (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_64C19C153C674EE ON category (offer_id)');
        $this->addSql('ALTER TABLE company DROP slug');
        $this->addSql('ALTER TABLE profil ADD title VARCHAR(255) NOT NULL, ADD location VARCHAR(255) NOT NULL, DROP title_profil, DROP location_profil, CHANGE description_profil description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE offer DROP slug');
    }
}
