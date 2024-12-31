<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241228110255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt ADD modifie_par_id INT DEFAULT NULL, ADD modifie_le_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7553B2554 FOREIGN KEY (modifie_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_364071D7553B2554 ON emprunt (modifie_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7553B2554');
        $this->addSql('DROP INDEX IDX_364071D7553B2554 ON emprunt');
        $this->addSql('ALTER TABLE emprunt DROP modifie_par_id, DROP modifie_le_at');
    }
}
