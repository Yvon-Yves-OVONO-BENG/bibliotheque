<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241228110432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt ADD supprime_par_id INT DEFAULT NULL, ADD supprime_le_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7ACC02199 FOREIGN KEY (supprime_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_364071D7ACC02199 ON emprunt (supprime_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7ACC02199');
        $this->addSql('DROP INDEX IDX_364071D7ACC02199 ON emprunt');
        $this->addSql('ALTER TABLE emprunt DROP supprime_par_id, DROP supprime_le_at');
    }
}
