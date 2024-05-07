<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422090706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE technologies DROP FOREIGN KEY FK_4CCBFB1812469DE2');
        $this->addSql('ALTER TABLE technology_categories DROP FOREIGN KEY FK_E74A135C727ACA70');
        $this->addSql('DROP TABLE technology_categories');
        $this->addSql('DROP INDEX IDX_4CCBFB1812469DE2 ON technologies');
        $this->addSql('ALTER TABLE technologies ADD slug VARCHAR(255) NOT NULL, CHANGE category_id parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE technologies ADD CONSTRAINT FK_4CCBFB18727ACA70 FOREIGN KEY (parent_id) REFERENCES technologies (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4CCBFB18989D9B62 ON technologies (slug)');
        $this->addSql('CREATE INDEX IDX_4CCBFB18727ACA70 ON technologies (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE technology_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_E74A135C727ACA70 (parent_id), UNIQUE INDEX UNIQ_E74A135C989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE technology_categories ADD CONSTRAINT FK_E74A135C727ACA70 FOREIGN KEY (parent_id) REFERENCES technology_categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE technologies DROP FOREIGN KEY FK_4CCBFB18727ACA70');
        $this->addSql('DROP INDEX UNIQ_4CCBFB18989D9B62 ON technologies');
        $this->addSql('DROP INDEX IDX_4CCBFB18727ACA70 ON technologies');
        $this->addSql('ALTER TABLE technologies DROP slug, CHANGE parent_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE technologies ADD CONSTRAINT FK_4CCBFB1812469DE2 FOREIGN KEY (category_id) REFERENCES technology_categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4CCBFB1812469DE2 ON technologies (category_id)');
    }
}
