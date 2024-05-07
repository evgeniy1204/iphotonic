<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240421165541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9941943989D9B62 ON product_categories (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B3BA5A5A989D9B62 ON products (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_B3BA5A5A989D9B62 ON products');
        $this->addSql('DROP INDEX UNIQ_A9941943989D9B62 ON product_categories');
    }
}
