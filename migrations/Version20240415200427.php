<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415200427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat ADD outil_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A984563ED89C80 FOREIGN KEY (outil_id) REFERENCES outil (id)');
        $this->addSql('CREATE INDEX IDX_26A984563ED89C80 ON achat (outil_id)');
        $this->addSql('ALTER TABLE outil ADD categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE outil ADD CONSTRAINT FK_22627A3EA21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_22627A3EA21214B7 ON outil (categories_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A984563ED89C80');
        $this->addSql('DROP INDEX IDX_26A984563ED89C80 ON achat');
        $this->addSql('ALTER TABLE achat DROP outil_id');
        $this->addSql('ALTER TABLE outil DROP FOREIGN KEY FK_22627A3EA21214B7');
        $this->addSql('DROP INDEX IDX_22627A3EA21214B7 ON outil');
        $this->addSql('ALTER TABLE outil DROP categories_id');
    }
}
