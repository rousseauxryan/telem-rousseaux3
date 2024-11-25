<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241122125217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE lignecommande');
        $this->addSql('DROP TABLE produit');
        $this->addSql('ALTER TABLE product CHANGE description description VARCHAR(2000) DEFAULT NULL, CHANGE price price INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (idClient INT AUTO_INCREMENT NOT NULL, civilite VARCHAR(10) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, nom VARCHAR(100) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, prenom VARCHAR(100) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, ville VARCHAR(150) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, cp VARCHAR(8) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, mail VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, tel VARCHAR(15) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, PRIMARY KEY(idClient)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, estPayee TINYINT(1) DEFAULT 0 NOT NULL, estExpediee TINYINT(1) DEFAULT 0 NOT NULL, client INT NOT NULL, INDEX client (client), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lignecommande (produit INT NOT NULL, commande INT NOT NULL, quantite INT NOT NULL, INDEX commande (commande), PRIMARY KEY(produit, commande)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit (idProduit INT AUTO_INCREMENT NOT NULL, designation TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, description TEXT CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, dateAjout DATETIME DEFAULT NULL, qte INT DEFAULT NULL, prix NUMERIC(6, 2) DEFAULT NULL, fichierImage VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_general_ci`, pk_fournisseur INT NOT NULL, PRIMARY KEY(idProduit)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_general_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE price price DOUBLE PRECISION NOT NULL');
    }
}
