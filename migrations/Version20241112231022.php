<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241112231022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C583C008');
        $this->addSql('CREATE TABLE etat_reservation (id INT AUTO_INCREMENT NOT NULL, etat_reservation VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE statut_reservation');
        $this->addSql('DROP INDEX IDX_42C84955C583C008 ON reservation');
        $this->addSql('ALTER TABLE reservation CHANGE statut_reservation_id etat_reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495514237FB FOREIGN KEY (etat_reservation_id) REFERENCES etat_reservation (id)');
        $this->addSql('CREATE INDEX IDX_42C8495514237FB ON reservation (etat_reservation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495514237FB');
        $this->addSql('CREATE TABLE statut_reservation (id INT AUTO_INCREMENT NOT NULL, statut_reservation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE etat_reservation');
        $this->addSql('DROP INDEX IDX_42C8495514237FB ON reservation');
        $this->addSql('ALTER TABLE reservation CHANGE etat_reservation_id statut_reservation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C583C008 FOREIGN KEY (statut_reservation_id) REFERENCES statut_reservation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_42C84955C583C008 ON reservation (statut_reservation_id)');
    }
}
