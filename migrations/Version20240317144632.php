<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240317144632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technologies ADD seo_title VARCHAR(255) NOT NULL, ADD seo_description LONGTEXT DEFAULT NULL, ADD metaTitle VARCHAR(255) DEFAULT NULL, ADD metaDescription VARCHAR(255) DEFAULT NULL, ADD metaKeywords VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technologies DROP seo_title, DROP seo_description, DROP metaTitle, DROP metaDescription, DROP metaKeywords');
    }
}
