<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329230606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY achat_ibfk_1');
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY achat_ibfk_2');
        $this->addSql('ALTER TABLE certificat DROP FOREIGN KEY certificat_ibfk_2');
        $this->addSql('ALTER TABLE certificat DROP FOREIGN KEY fk_idFormation_certif');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_2');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_1');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY cours_ibfk_1');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY evaluation_ibfk_1');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY formation_ibfk_1');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY formation_ibfk_2');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY forum_ibfk_1');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY fk_idFormation');
        $this->addSql('ALTER TABLE outil DROP FOREIGN KEY outil_ibfk_1');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY publication_ibfk_2');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY publication_ibfk_1');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY question_ibfk_1');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY reclamation_ibfk_2');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY reclamation_ibfk_3');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY reclamation_ibfk_1');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY reponse_ibfk_2');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY reponse_ibfk_1');
        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE certificat');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE outil');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat (idAchat INT AUTO_INCREMENT NOT NULL, idFormation INT DEFAULT NULL, idOutil INT DEFAULT NULL, total DOUBLE PRECISION NOT NULL, date DATE NOT NULL, INDEX idFormation (idFormation), INDEX idOutil (idOutil), PRIMARY KEY(idAchat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE categorie (idCategorie INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idCategorie)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE certificat (idCertificat INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateObtention DATE NOT NULL, nbrCours INT NOT NULL, idUser INT DEFAULT NULL, idFormation INT DEFAULT NULL, INDEX idFormation (idFormation), INDEX idUser (idUser), PRIMARY KEY(idCertificat)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commentaire (idCommentaire INT AUTO_INCREMENT NOT NULL, dateCreation DATETIME NOT NULL, contenu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idUser INT DEFAULT NULL, idP INT DEFAULT NULL, rating INT DEFAULT NULL, INDEX idUser (idUser), INDEX idP (idP), PRIMARY KEY(idCommentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cours (id_cours INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATE NOT NULL, duree INT NOT NULL, prerequis VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, ressource VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idFormation INT DEFAULT NULL, INDEX idFormation (idFormation), PRIMARY KEY(id_cours)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE evaluation (id_e INT AUTO_INCREMENT NOT NULL, id_cours INT DEFAULT NULL, duree INT NOT NULL, note INT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX id_cours (id_cours), PRIMARY KEY(id_e)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE formation (idFormation INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateD DATE NOT NULL, dateF DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, nbrCours INT NOT NULL, imageUrl VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idUser INT DEFAULT NULL, idCategorie INT DEFAULT NULL, INDEX idUser (idUser), INDEX idCategorie (idCategorie), PRIMARY KEY(idFormation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE forum (idForum INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateCreation DATETIME NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idFormation INT DEFAULT NULL, INDEX idFormation (idFormation), PRIMARY KEY(idForum)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE offre (idOffre INT AUTO_INCREMENT NOT NULL, prixOffre DOUBLE PRECISION NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateD DATE NOT NULL, dateF DATE NOT NULL, idFormation INT DEFAULT NULL, INDEX idFormation (idFormation), PRIMARY KEY(idOffre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE outil (idoutils INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix DOUBLE PRECISION NOT NULL, ressources VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, stock VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etat VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idCategorie INT NOT NULL, INDEX idCategorie (idCategorie), PRIMARY KEY(idoutils)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE publication (idP INT AUTO_INCREMENT NOT NULL, dateCreation DATETIME NOT NULL, contenuP TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, nbLike INT DEFAULT NULL, idForum INT DEFAULT NULL, idUser INT DEFAULT NULL, INDEX idForum (idForum), INDEX idUser (idUser), PRIMARY KEY(idP)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE question (id_q INT AUTO_INCREMENT NOT NULL, id_e INT DEFAULT NULL, ressource VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, point INT NOT NULL, duree INT NOT NULL, INDEX id_e (id_e), PRIMARY KEY(id_q)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reclamation (id_reclamation INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, id_outil INT NOT NULL, id_formation INT NOT NULL, description VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATETIME NOT NULL, INDEX id_outil (id_outil), INDEX id_user (id_user), INDEX id_formation (id_formation), PRIMARY KEY(id_reclamation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reponse (id_reponse INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, id_reclamation INT NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_reponse DATETIME NOT NULL, INDEX id_reclamation (id_reclamation), INDEX id_user (id_user), PRIMARY KEY(id_reponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (idUser INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, dateNaissance DATE NOT NULL, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, numtel INT NOT NULL, mdp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, role INT NOT NULL, specialite VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, niveauAcademique VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, disponiblite INT DEFAULT NULL, cv VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, niveau_scolaire VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idUser)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT achat_ibfk_1 FOREIGN KEY (idFormation) REFERENCES formation (idFormation)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT achat_ibfk_2 FOREIGN KEY (idOutil) REFERENCES outil (idoutils)');
        $this->addSql('ALTER TABLE certificat ADD CONSTRAINT certificat_ibfk_2 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE certificat ADD CONSTRAINT fk_idFormation_certif FOREIGN KEY (idFormation) REFERENCES formation (idFormation) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_2 FOREIGN KEY (idP) REFERENCES publication (idP)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT cours_ibfk_1 FOREIGN KEY (idFormation) REFERENCES formation (idFormation)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT evaluation_ibfk_1 FOREIGN KEY (id_cours) REFERENCES cours (id_cours)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT formation_ibfk_1 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT formation_ibfk_2 FOREIGN KEY (idCategorie) REFERENCES categorie (idCategorie)');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT forum_ibfk_1 FOREIGN KEY (idFormation) REFERENCES formation (idFormation)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT fk_idFormation FOREIGN KEY (idFormation) REFERENCES formation (idFormation) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE outil ADD CONSTRAINT outil_ibfk_1 FOREIGN KEY (idCategorie) REFERENCES categorie (idCategorie)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT publication_ibfk_2 FOREIGN KEY (idUser) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT publication_ibfk_1 FOREIGN KEY (idForum) REFERENCES forum (idForum)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT question_ibfk_1 FOREIGN KEY (id_e) REFERENCES evaluation (id_e)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT reclamation_ibfk_2 FOREIGN KEY (id_outil) REFERENCES outil (idoutils)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT reclamation_ibfk_3 FOREIGN KEY (id_user) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT reclamation_ibfk_1 FOREIGN KEY (id_formation) REFERENCES formation (idFormation)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT reponse_ibfk_2 FOREIGN KEY (id_user) REFERENCES user (idUser)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT reponse_ibfk_1 FOREIGN KEY (id_reclamation) REFERENCES reclamation (id_reclamation)');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
