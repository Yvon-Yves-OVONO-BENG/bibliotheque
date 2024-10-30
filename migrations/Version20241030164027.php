<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241030164027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mode_paiement (id INT AUTO_INCREMENT NOT NULL, mode_paiement VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emprunt ADD mode_paiement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7438F5B63 FOREIGN KEY (mode_paiement_id) REFERENCES mode_paiement (id)');
        $this->addSql('CREATE INDEX IDX_364071D7438F5B63 ON emprunt (mode_paiement_id)');
        $this->addSql('ALTER TABLE penalite ADD mode_paiement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE penalite ADD CONSTRAINT FK_C62D8C5D438F5B63 FOREIGN KEY (mode_paiement_id) REFERENCES mode_paiement (id)');
        $this->addSql('CREATE INDEX IDX_C62D8C5D438F5B63 ON penalite (mode_paiement_id)');
        $this->addSql('ALTER TABLE reservation ADD mode_paiement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955438F5B63 FOREIGN KEY (mode_paiement_id) REFERENCES mode_paiement (id)');
        $this->addSql('CREATE INDEX IDX_42C84955438F5B63 ON reservation (mode_paiement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7438F5B63');
        $this->addSql('ALTER TABLE penalite DROP FOREIGN KEY FK_C62D8C5D438F5B63');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955438F5B63');
        $this->addSql('DROP TABLE mode_paiement');
        $this->addSql('DROP INDEX IDX_364071D7438F5B63 ON emprunt');
        $this->addSql('ALTER TABLE emprunt DROP mode_paiement_id');
        $this->addSql('DROP INDEX IDX_C62D8C5D438F5B63 ON penalite');
        $this->addSql('ALTER TABLE penalite DROP mode_paiement_id');
        $this->addSql('DROP INDEX IDX_42C84955438F5B63 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP mode_paiement_id');
    }
}
