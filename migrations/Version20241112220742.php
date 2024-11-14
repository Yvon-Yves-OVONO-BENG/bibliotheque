<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241112220742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE penalite DROP FOREIGN KEY FK_C62D8C5D53E537D1');
        $this->addSql('CREATE TABLE etat_paiement (id INT AUTO_INCREMENT NOT NULL, etat_paiement VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE statut_paiement');
        $this->addSql('ALTER TABLE emprunt ADD etat_paiement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D74738ECAF FOREIGN KEY (etat_paiement_id) REFERENCES etat_paiement (id)');
        $this->addSql('CREATE INDEX IDX_364071D74738ECAF ON emprunt (etat_paiement_id)');
        $this->addSql('DROP INDEX IDX_C62D8C5D53E537D1 ON penalite');
        $this->addSql('ALTER TABLE penalite CHANGE statut_paiement_id etat_paiement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE penalite ADD CONSTRAINT FK_C62D8C5D4738ECAF FOREIGN KEY (etat_paiement_id) REFERENCES etat_paiement (id)');
        $this->addSql('CREATE INDEX IDX_C62D8C5D4738ECAF ON penalite (etat_paiement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D74738ECAF');
        $this->addSql('ALTER TABLE penalite DROP FOREIGN KEY FK_C62D8C5D4738ECAF');
        $this->addSql('CREATE TABLE statut_paiement (id INT AUTO_INCREMENT NOT NULL, statut_paiement VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE etat_paiement');
        $this->addSql('DROP INDEX IDX_364071D74738ECAF ON emprunt');
        $this->addSql('ALTER TABLE emprunt DROP etat_paiement_id');
        $this->addSql('DROP INDEX IDX_C62D8C5D4738ECAF ON penalite');
        $this->addSql('ALTER TABLE penalite CHANGE etat_paiement_id statut_paiement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE penalite ADD CONSTRAINT FK_C62D8C5D53E537D1 FOREIGN KEY (statut_paiement_id) REFERENCES statut_paiement (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_C62D8C5D53E537D1 ON penalite (statut_paiement_id)');
    }
}
