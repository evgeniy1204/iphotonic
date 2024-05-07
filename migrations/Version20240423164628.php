<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423164628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about_us CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE applications CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE events CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE created_event_start_at created_event_start_at DATETIME DEFAULT NULL, CHANGE created_event_end_at created_event_end_at DATETIME DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE news CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE text text LONGTEXT DEFAULT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE partners CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE contacts contacts LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE possibilities CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_categories CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE products CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE images images LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE files files LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE slug slug VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE events CHANGE title title VARCHAR(255) NOT NULL, CHANGE created_event_start_at created_event_start_at DATETIME NOT NULL, CHANGE created_event_end_at created_event_end_at DATETIME NOT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE news CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE text text LONGTEXT NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE partners CHANGE name name VARCHAR(255) NOT NULL, CHANGE contacts contacts LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE possibilities CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product_categories CHANGE name name VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE products CHANGE images images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE files files LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE name name VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE applications CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE about_us CHANGE description description VARCHAR(255) NOT NULL');
    }
}
