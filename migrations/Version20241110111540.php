<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241110111540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genre_litteraire ADD enregistre_par_id INT DEFAULT NULL, ADD modifie_par_id INT DEFAULT NULL, ADD supprime_par_id INT DEFAULT NULL, ADD enregistre_le_at DATETIME NOT NULL, ADD modifie_le_at DATETIME DEFAULT NULL, ADD supprime_le_at DATETIME DEFAULT NULL, ADD supprime TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE genre_litteraire ADD CONSTRAINT FK_ABA39F2CCB5FDB3E FOREIGN KEY (enregistre_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE genre_litteraire ADD CONSTRAINT FK_ABA39F2C553B2554 FOREIGN KEY (modifie_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE genre_litteraire ADD CONSTRAINT FK_ABA39F2CACC02199 FOREIGN KEY (supprime_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_ABA39F2CCB5FDB3E ON genre_litteraire (enregistre_par_id)');
        $this->addSql('CREATE INDEX IDX_ABA39F2C553B2554 ON genre_litteraire (modifie_par_id)');
        $this->addSql('CREATE INDEX IDX_ABA39F2CACC02199 ON genre_litteraire (supprime_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE genre_litteraire DROP FOREIGN KEY FK_ABA39F2CCB5FDB3E');
        $this->addSql('ALTER TABLE genre_litteraire DROP FOREIGN KEY FK_ABA39F2C553B2554');
        $this->addSql('ALTER TABLE genre_litteraire DROP FOREIGN KEY FK_ABA39F2CACC02199');
        $this->addSql('DROP INDEX IDX_ABA39F2CCB5FDB3E ON genre_litteraire');
        $this->addSql('DROP INDEX IDX_ABA39F2C553B2554 ON genre_litteraire');
        $this->addSql('DROP INDEX IDX_ABA39F2CACC02199 ON genre_litteraire');
        $this->addSql('ALTER TABLE genre_litteraire DROP enregistre_par_id, DROP modifie_par_id, DROP supprime_par_id, DROP enregistre_le_at, DROP modifie_le_at, DROP supprime_le_at, DROP supprime');
    }
}
