<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241228152305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D737D925CB');
        $this->addSql('DROP INDEX IDX_364071D737D925CB ON emprunt');
        $this->addSql('ALTER TABLE emprunt DROP livre_id, DROP date_retour_prevue_at, DROP date_retour_reelle_at, DROP nombre');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt ADD livre_id INT DEFAULT NULL, ADD date_retour_prevue_at DATE NOT NULL, ADD date_retour_reelle_at DATETIME DEFAULT NULL, ADD nombre INT NOT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_364071D737D925CB ON emprunt (livre_id)');
    }
}
