<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403140308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATE NOT NULL, duree INT NOT NULL, prerequis VARCHAR(255) NOT NULL, ressource VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, id_formation INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, cours_id INT NOT NULL, note INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_1323A5757ECF78B0 (cours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT NOT NULL, ressource VARCHAR(255) NOT NULL, duree INT NOT NULL, point INT NOT NULL, choix1 VARCHAR(255) NOT NULL, choix2 VARCHAR(255) NOT NULL, choix3 VARCHAR(255) NOT NULL, reponse VARCHAR(255) DEFAULT NULL, crx VARCHAR(255) NOT NULL, INDEX IDX_B6F7494E456C5646 (evaluation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (idUser INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, dateNaissance DATE NOT NULL, adresse VARCHAR(255) NOT NULL, numtel INT NOT NULL, imageProfil VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, role INT NOT NULL, specialite VARCHAR(255) NOT NULL, niveauAcademique VARCHAR(255) NOT NULL, disponiblite INT NOT NULL, cv VARCHAR(255) NOT NULL, niveau_scolaire VARCHAR(255) NOT NULL, PRIMARY KEY(idUser)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5757ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5757ECF78B0');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E456C5646');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
