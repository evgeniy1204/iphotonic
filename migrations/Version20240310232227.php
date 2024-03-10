<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310232227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pages CHANGE metaTitle metaTitle VARCHAR(255) DEFAULT NULL, CHANGE metaDescription metaDescription VARCHAR(255) DEFAULT NULL, CHANGE metaKeywords metaKeywords VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pages CHANGE metaTitle metaTitle VARCHAR(255) NOT NULL, CHANGE metaDescription metaDescription VARCHAR(255) NOT NULL, CHANGE metaKeywords metaKeywords VARCHAR(255) NOT NULL, CHANGE type type VARCHAR(255) NOT NULL');
    }
}
