<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241228105340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D72A2B9AAE');
        $this->addSql('DROP INDEX IDX_364071D72A2B9AAE ON emprunt');
        $this->addSql('ALTER TABLE emprunt CHANGE enregistrer_par_id enregistre_par_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7CB5FDB3E FOREIGN KEY (enregistre_par_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_364071D7CB5FDB3E ON emprunt (enregistre_par_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7CB5FDB3E');
        $this->addSql('DROP INDEX IDX_364071D7CB5FDB3E ON emprunt');
        $this->addSql('ALTER TABLE emprunt CHANGE enregistre_par_id enregistrer_par_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D72A2B9AAE FOREIGN KEY (enregistrer_par_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_364071D72A2B9AAE ON emprunt (enregistrer_par_id)');
    }
}
