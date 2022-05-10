<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414222753 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, vol_id INT NOT NULL, type VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, final_price DOUBLE PRECISION NOT NULL, INDEX IDX_42C8495519EB6921 (client_id), INDEX IDX_42C849559F2BFB7A (vol_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vol (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, origin VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, departure_date DATETIME NOT NULL, arrival_date DATETIME NOT NULL, status TINYINT(1) NOT NULL, initial_price DOUBLE PRECISION NOT NULL, INDEX IDX_95C97EB979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559F2BFB7A FOREIGN KEY (vol_id) REFERENCES vol (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB979B1AD6');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559F2BFB7A');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE vol');
    }
}
