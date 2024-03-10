<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310134917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technologies (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology_technology_category (technology_id INT NOT NULL, technology_category_id INT NOT NULL, INDEX IDX_515928C34235D463 (technology_id), INDEX IDX_515928C3332FD002 (technology_category_id), PRIMARY KEY(technology_id, technology_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE technology_technology_category ADD CONSTRAINT FK_515928C34235D463 FOREIGN KEY (technology_id) REFERENCES technologies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technology_technology_category ADD CONSTRAINT FK_515928C3332FD002 FOREIGN KEY (technology_category_id) REFERENCES technology_categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technology_technology_category DROP FOREIGN KEY FK_515928C34235D463');
        $this->addSql('ALTER TABLE technology_technology_category DROP FOREIGN KEY FK_515928C3332FD002');
        $this->addSql('DROP TABLE technologies');
        $this->addSql('DROP TABLE technology_technology_category');
    }
}
