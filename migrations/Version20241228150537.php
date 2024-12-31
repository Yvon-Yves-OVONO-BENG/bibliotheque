<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241228150537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ligne_emprunt (id INT AUTO_INCREMENT NOT NULL, emprunt_id INT DEFAULT NULL, livre_id INT DEFAULT NULL, quantite INT NOT NULL, date_retour_prevue_at DATETIME NOT NULL, date_retour_reelle_at DATETIME DEFAULT NULL, montant_emprunt INT NOT NULL, INDEX IDX_A9D94FEEAE7FEF94 (emprunt_id), INDEX IDX_A9D94FEE37D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ligne_emprunt ADD CONSTRAINT FK_A9D94FEEAE7FEF94 FOREIGN KEY (emprunt_id) REFERENCES emprunt (id)');
        $this->addSql('ALTER TABLE ligne_emprunt ADD CONSTRAINT FK_A9D94FEE37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ligne_emprunt DROP FOREIGN KEY FK_A9D94FEEAE7FEF94');
        $this->addSql('ALTER TABLE ligne_emprunt DROP FOREIGN KEY FK_A9D94FEE37D925CB');
        $this->addSql('DROP TABLE ligne_emprunt');
    }
}
