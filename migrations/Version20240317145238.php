<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240317145238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applications DROP seo_title, DROP seo_description');
        $this->addSql('ALTER TABLE products DROP seo_title, DROP seo_description');
        $this->addSql('ALTER TABLE technologies DROP seo_title, DROP seo_description');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products ADD seo_title VARCHAR(255) NOT NULL, ADD seo_description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE technologies ADD seo_title VARCHAR(255) NOT NULL, ADD seo_description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE applications ADD seo_title VARCHAR(255) NOT NULL, ADD seo_description LONGTEXT DEFAULT NULL');
    }
}
