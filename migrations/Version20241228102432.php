<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241228102432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exemplaire ADD supprime_par_id INT DEFAULT NULL, ADD supprime TINYINT(1) DEFAULT NULL, ADD supprime_le_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C92ACC02199 FOREIGN KEY (supprime_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5EF83C92ACC02199 ON exemplaire (supprime_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C92ACC02199');
        $this->addSql('DROP INDEX IDX_5EF83C92ACC02199 ON exemplaire');
        $this->addSql('ALTER TABLE exemplaire DROP supprime_par_id, DROP supprime, DROP supprime_le_at');
    }
}
