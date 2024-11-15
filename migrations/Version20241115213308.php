<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241115213308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, livre_id INT DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_14B7841837D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B7841837D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE livre ADD enregistre_par_id INT DEFAULT NULL, ADD enregistre_le_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD supprime TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99CB5FDB3E FOREIGN KEY (enregistre_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC634F99CB5FDB3E ON livre (enregistre_par_id)');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B7841837D925CB');
        $this->addSql('DROP TABLE photo');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99CB5FDB3E');
        $this->addSql('DROP INDEX IDX_AC634F99CB5FDB3E ON livre');
        $this->addSql('ALTER TABLE livre DROP enregistre_par_id, DROP enregistre_le_at, DROP supprime');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL');
    }
}
