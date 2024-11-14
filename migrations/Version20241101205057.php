<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101205057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE armoire (id INT AUTO_INCREMENT NOT NULL, enregistre_par_id INT DEFAULT NULL, modifie_par_id INT DEFAULT NULL, supprime_par_id INT DEFAULT NULL, armoire VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, enregistre_le_at DATETIME NOT NULL, modifie_le_at DATETIME DEFAULT NULL, supprime_le_at DATETIME DEFAULT NULL, nombre_etagere INT NOT NULL, INDEX IDX_93771E40CB5FDB3E (enregistre_par_id), INDEX IDX_93771E40553B2554 (modifie_par_id), INDEX IDX_93771E40ACC02199 (supprime_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, nationalite_id INT DEFAULT NULL, sexe_id INT DEFAULT NULL, enregistre_par_id INT DEFAULT NULL, modifie_par_id INT DEFAULT NULL, supprime_par_id INT DEFAULT NULL, type_auteur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, date_naissance_at DATE NOT NULL, biographie VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, enregistre_le_at DATETIME NOT NULL, modifie_le_at DATETIME DEFAULT NULL, supprime_le_at DATETIME DEFAULT NULL, INDEX IDX_55AB1401B063272 (nationalite_id), INDEX IDX_55AB140448F3B3C (sexe_id), INDEX IDX_55AB140CB5FDB3E (enregistre_par_id), INDEX IDX_55AB140553B2554 (modifie_par_id), INDEX IDX_55AB140ACC02199 (supprime_par_id), INDEX IDX_55AB140D47D2EF6 (type_auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire_livre (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, commentaire VARCHAR(255) NOT NULL, date_commentaire_at DATETIME NOT NULL, INDEX IDX_29EF87856A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editeur (id INT AUTO_INCREMENT NOT NULL, editeur VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, livre_id INT DEFAULT NULL, statut_emprunt_id INT DEFAULT NULL, mode_paiement_id INT DEFAULT NULL, date_emprunt_at DATETIME NOT NULL, date_retour_prevue_at DATE NOT NULL, date_retour_reelle_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_364071D76A99F74A (membre_id), INDEX IDX_364071D737D925CB (livre_id), INDEX IDX_364071D7DBB4E29D (statut_emprunt_id), INDEX IDX_364071D7438F5B63 (mode_paiement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_exemplaire (id INT AUTO_INCREMENT NOT NULL, etat_exemplaire VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exemplaire (id INT AUTO_INCREMENT NOT NULL, livre_id INT DEFAULT NULL, etat_exemplaire_id INT DEFAULT NULL, membre_id INT DEFAULT NULL, date_acquisition_at DATETIME NOT NULL, code_exemplaire VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_5EF83C9237D925CB (livre_id), INDEX IDX_5EF83C924E37BF57 (etat_exemplaire_id), INDEX IDX_5EF83C926A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE face (id INT AUTO_INCREMENT NOT NULL, face VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre_litteraire (id INT AUTO_INCREMENT NOT NULL, genre_litteraire VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE langue (id INT AUTO_INCREMENT NOT NULL, langue VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, genre_litteraire_id INT DEFAULT NULL, auteur_id INT DEFAULT NULL, editeur_id INT DEFAULT NULL, langue_id INT DEFAULT NULL, statut_livre_id INT DEFAULT NULL, fournisseur_id INT DEFAULT NULL, armoire_id INT DEFAULT NULL, face_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, date_publication_at DATE NOT NULL, nombre_exemplaire INT NOT NULL, resume VARCHAR(255) NOT NULL, photo VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, niveau INT NOT NULL, INDEX IDX_AC634F99EE101E98 (genre_litteraire_id), INDEX IDX_AC634F9960BB6FE6 (auteur_id), INDEX IDX_AC634F993375BD21 (editeur_id), INDEX IDX_AC634F992AADBACD (langue_id), INDEX IDX_AC634F9948DF996A (statut_livre_id), INDEX IDX_AC634F99670C757F (fournisseur_id), INDEX IDX_AC634F99CFB9323 (armoire_id), INDEX IDX_AC634F99FDC86CD0 (face_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mode_paiement (id INT AUTO_INCREMENT NOT NULL, mode_paiement VARCHAR(255) NOT NULL, supprime TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nationalite (id INT AUTO_INCREMENT NOT NULL, nationalite VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_etoile_livre (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, note VARCHAR(255) NOT NULL, date_note_at DATETIME NOT NULL, INDEX IDX_1548E2C6A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE penalite (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, statut_paiement_id INT DEFAULT NULL, mode_paiement_id INT DEFAULT NULL, montant INT NOT NULL, date_application_at DATETIME NOT NULL, INDEX IDX_C62D8C5D6A99F74A (membre_id), INDEX IDX_C62D8C5D53E537D1 (statut_paiement_id), INDEX IDX_C62D8C5D438F5B63 (mode_paiement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, livre_id INT DEFAULT NULL, statut_reservation_id INT DEFAULT NULL, mode_paiement_id INT DEFAULT NULL, date_reservation_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_42C849556A99F74A (membre_id), INDEX IDX_42C8495537D925CB (livre_id), INDEX IDX_42C84955C583C008 (statut_reservation_id), INDEX IDX_42C84955438F5B63 (mode_paiement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sexe (id INT AUTO_INCREMENT NOT NULL, sexe VARCHAR(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_emprunt (id INT AUTO_INCREMENT NOT NULL, statut_emprunt VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_livre (id INT AUTO_INCREMENT NOT NULL, statut_livre VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_paiement (id INT AUTO_INCREMENT NOT NULL, statut_paiement VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_penalite (id INT AUTO_INCREMENT NOT NULL, statut_penalite VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_reservation (id INT AUTO_INCREMENT NOT NULL, statut_reservation VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_auteur (id INT AUTO_INCREMENT NOT NULL, type_auteur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, membre_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, bloque TINYINT(1) NOT NULL, nom VARCHAR(255) NOT NULL, temoin VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6496A99F74A (membre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE armoire ADD CONSTRAINT FK_93771E40CB5FDB3E FOREIGN KEY (enregistre_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE armoire ADD CONSTRAINT FK_93771E40553B2554 FOREIGN KEY (modifie_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE armoire ADD CONSTRAINT FK_93771E40ACC02199 FOREIGN KEY (supprime_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE auteur ADD CONSTRAINT FK_55AB1401B063272 FOREIGN KEY (nationalite_id) REFERENCES nationalite (id)');
        $this->addSql('ALTER TABLE auteur ADD CONSTRAINT FK_55AB140448F3B3C FOREIGN KEY (sexe_id) REFERENCES sexe (id)');
        $this->addSql('ALTER TABLE auteur ADD CONSTRAINT FK_55AB140CB5FDB3E FOREIGN KEY (enregistre_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE auteur ADD CONSTRAINT FK_55AB140553B2554 FOREIGN KEY (modifie_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE auteur ADD CONSTRAINT FK_55AB140ACC02199 FOREIGN KEY (supprime_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE auteur ADD CONSTRAINT FK_55AB140D47D2EF6 FOREIGN KEY (type_auteur_id) REFERENCES type_auteur (id)');
        $this->addSql('ALTER TABLE commentaire_livre ADD CONSTRAINT FK_29EF87856A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D76A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7DBB4E29D FOREIGN KEY (statut_emprunt_id) REFERENCES statut_emprunt (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7438F5B63 FOREIGN KEY (mode_paiement_id) REFERENCES mode_paiement (id)');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C9237D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C924E37BF57 FOREIGN KEY (etat_exemplaire_id) REFERENCES etat_exemplaire (id)');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C926A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99EE101E98 FOREIGN KEY (genre_litteraire_id) REFERENCES genre_litteraire (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9960BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F993375BD21 FOREIGN KEY (editeur_id) REFERENCES editeur (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F992AADBACD FOREIGN KEY (langue_id) REFERENCES langue (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9948DF996A FOREIGN KEY (statut_livre_id) REFERENCES statut_livre (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99CFB9323 FOREIGN KEY (armoire_id) REFERENCES armoire (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99FDC86CD0 FOREIGN KEY (face_id) REFERENCES face (id)');
        $this->addSql('ALTER TABLE note_etoile_livre ADD CONSTRAINT FK_1548E2C6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE penalite ADD CONSTRAINT FK_C62D8C5D6A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE penalite ADD CONSTRAINT FK_C62D8C5D53E537D1 FOREIGN KEY (statut_paiement_id) REFERENCES statut_paiement (id)');
        $this->addSql('ALTER TABLE penalite ADD CONSTRAINT FK_C62D8C5D438F5B63 FOREIGN KEY (mode_paiement_id) REFERENCES mode_paiement (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849556A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495537D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955C583C008 FOREIGN KEY (statut_reservation_id) REFERENCES statut_reservation (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955438F5B63 FOREIGN KEY (mode_paiement_id) REFERENCES mode_paiement (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6496A99F74A FOREIGN KEY (membre_id) REFERENCES membre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE armoire DROP FOREIGN KEY FK_93771E40CB5FDB3E');
        $this->addSql('ALTER TABLE armoire DROP FOREIGN KEY FK_93771E40553B2554');
        $this->addSql('ALTER TABLE armoire DROP FOREIGN KEY FK_93771E40ACC02199');
        $this->addSql('ALTER TABLE auteur DROP FOREIGN KEY FK_55AB1401B063272');
        $this->addSql('ALTER TABLE auteur DROP FOREIGN KEY FK_55AB140448F3B3C');
        $this->addSql('ALTER TABLE auteur DROP FOREIGN KEY FK_55AB140CB5FDB3E');
        $this->addSql('ALTER TABLE auteur DROP FOREIGN KEY FK_55AB140553B2554');
        $this->addSql('ALTER TABLE auteur DROP FOREIGN KEY FK_55AB140ACC02199');
        $this->addSql('ALTER TABLE auteur DROP FOREIGN KEY FK_55AB140D47D2EF6');
        $this->addSql('ALTER TABLE commentaire_livre DROP FOREIGN KEY FK_29EF87856A99F74A');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D76A99F74A');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D737D925CB');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7DBB4E29D');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7438F5B63');
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C9237D925CB');
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C924E37BF57');
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C926A99F74A');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99EE101E98');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9960BB6FE6');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F993375BD21');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F992AADBACD');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9948DF996A');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99670C757F');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99CFB9323');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99FDC86CD0');
        $this->addSql('ALTER TABLE note_etoile_livre DROP FOREIGN KEY FK_1548E2C6A99F74A');
        $this->addSql('ALTER TABLE penalite DROP FOREIGN KEY FK_C62D8C5D6A99F74A');
        $this->addSql('ALTER TABLE penalite DROP FOREIGN KEY FK_C62D8C5D53E537D1');
        $this->addSql('ALTER TABLE penalite DROP FOREIGN KEY FK_C62D8C5D438F5B63');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849556A99F74A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495537D925CB');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955C583C008');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955438F5B63');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6496A99F74A');
        $this->addSql('DROP TABLE armoire');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE commentaire_livre');
        $this->addSql('DROP TABLE editeur');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE etat_exemplaire');
        $this->addSql('DROP TABLE exemplaire');
        $this->addSql('DROP TABLE face');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE genre_litteraire');
        $this->addSql('DROP TABLE langue');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE membre');
        $this->addSql('DROP TABLE mode_paiement');
        $this->addSql('DROP TABLE nationalite');
        $this->addSql('DROP TABLE note_etoile_livre');
        $this->addSql('DROP TABLE penalite');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE sexe');
        $this->addSql('DROP TABLE statut_emprunt');
        $this->addSql('DROP TABLE statut_livre');
        $this->addSql('DROP TABLE statut_paiement');
        $this->addSql('DROP TABLE statut_penalite');
        $this->addSql('DROP TABLE statut_reservation');
        $this->addSql('DROP TABLE type_auteur');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
