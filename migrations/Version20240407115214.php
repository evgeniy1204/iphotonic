<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240407115214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE memberships');
        $this->addSql('ALTER TABLE events ADD summary LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE news ADD summary LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD summary LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE settings ADD membership_logos LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
		$this->addSql('ALTER TABLE products ADD files LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
		$this->addSql('ALTER TABLE product_categories ADD technology_id INT DEFAULT NULL');
		$this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A99419434235D463 FOREIGN KEY (technology_id) REFERENCES technologies (id)');
		$this->addSql('CREATE INDEX IDX_A99419434235D463 ON product_categories (technology_id)');
		$this->addSql('ALTER TABLE product_categories ADD summary LONGTEXT NOT NULL, ADD description LONGTEXT NOT NULL');
	}

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE memberships (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, logo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE settings DROP membership_logos');
        $this->addSql('ALTER TABLE events DROP summary');
        $this->addSql('ALTER TABLE products DROP summary');
        $this->addSql('ALTER TABLE news DROP summary');
		$this->addSql('ALTER TABLE products DROP files');
		$this->addSql('ALTER TABLE product_categories DROP FOREIGN KEY FK_A99419434235D463');
		$this->addSql('DROP INDEX IDX_A99419434235D463 ON product_categories');
		$this->addSql('ALTER TABLE product_categories DROP technology_id');
		$this->addSql('ALTER TABLE product_categories DROP summary, DROP description');
    }
}
