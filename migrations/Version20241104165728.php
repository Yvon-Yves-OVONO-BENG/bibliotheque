<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104165728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE editeur ADD enregistre_par_id INT DEFAULT NULL, ADD modifie_par_id INT DEFAULT NULL, ADD supprime_par_id INT DEFAULT NULL, ADD supprime TINYINT(1) NOT NULL, ADD enregistre_le_at DATETIME NOT NULL, ADD modifie_le_at DATETIME DEFAULT NULL, ADD supprime_le_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE editeur ADD CONSTRAINT FK_5A747EFCB5FDB3E FOREIGN KEY (enregistre_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE editeur ADD CONSTRAINT FK_5A747EF553B2554 FOREIGN KEY (modifie_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE editeur ADD CONSTRAINT FK_5A747EFACC02199 FOREIGN KEY (supprime_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A747EFCB5FDB3E ON editeur (enregistre_par_id)');
        $this->addSql('CREATE INDEX IDX_5A747EF553B2554 ON editeur (modifie_par_id)');
        $this->addSql('CREATE INDEX IDX_5A747EFACC02199 ON editeur (supprime_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE editeur DROP FOREIGN KEY FK_5A747EFCB5FDB3E');
        $this->addSql('ALTER TABLE editeur DROP FOREIGN KEY FK_5A747EF553B2554');
        $this->addSql('ALTER TABLE editeur DROP FOREIGN KEY FK_5A747EFACC02199');
        $this->addSql('DROP INDEX IDX_5A747EFCB5FDB3E ON editeur');
        $this->addSql('DROP INDEX IDX_5A747EF553B2554 ON editeur');
        $this->addSql('DROP INDEX IDX_5A747EFACC02199 ON editeur');
        $this->addSql('ALTER TABLE editeur DROP enregistre_par_id, DROP modifie_par_id, DROP supprime_par_id, DROP supprime, DROP enregistre_le_at, DROP modifie_le_at, DROP supprime_le_at');
    }
}
