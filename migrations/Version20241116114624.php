<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116114624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre ADD modifie_par_id INT DEFAULT NULL, ADD supprime_par_id INT DEFAULT NULL, ADD modifie_le_at DATETIME DEFAULT NULL, ADD supprime_le_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99553B2554 FOREIGN KEY (modifie_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99ACC02199 FOREIGN KEY (supprime_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC634F99553B2554 ON livre (modifie_par_id)');
        $this->addSql('CREATE INDEX IDX_AC634F99ACC02199 ON livre (supprime_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99553B2554');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99ACC02199');
        $this->addSql('DROP INDEX IDX_AC634F99553B2554 ON livre');
        $this->addSql('DROP INDEX IDX_AC634F99ACC02199 ON livre');
        $this->addSql('ALTER TABLE livre DROP modifie_par_id, DROP supprime_par_id, DROP modifie_le_at, DROP supprime_le_at');
    }
}
