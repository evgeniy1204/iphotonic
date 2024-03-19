<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240311174230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_4D707784727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE applications (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F7C966F012469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_event_start_at DATETIME NOT NULL, created_event_end_at DATETIME NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, text LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE memberships (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, text LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pages (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, metaTitle VARCHAR(255) DEFAULT NULL, metaDescription VARCHAR(255) DEFAULT NULL, metaKeywords VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partners (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, contacts LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A9941943727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_B3BA5A5A12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_technology (product_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_67040D664584665A (product_id), INDEX IDX_67040D664235D463 (technology_id), PRIMARY KEY(product_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_application (product_id INT NOT NULL, application_id INT NOT NULL, INDEX IDX_87443DE4584665A (product_id), INDEX IDX_87443DE3E030ACD (application_id), PRIMARY KEY(product_id, application_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technologies (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, text LONGTEXT DEFAULT NULL, INDEX IDX_4CCBFB1812469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE technology_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E74A135C727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application_categories ADD CONSTRAINT FK_4D707784727ACA70 FOREIGN KEY (parent_id) REFERENCES application_categories (id)');
        $this->addSql('ALTER TABLE applications ADD CONSTRAINT FK_F7C966F012469DE2 FOREIGN KEY (category_id) REFERENCES application_categories (id)');
        $this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A9941943727ACA70 FOREIGN KEY (parent_id) REFERENCES product_categories (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES product_categories (id)');
        $this->addSql('ALTER TABLE product_technology ADD CONSTRAINT FK_67040D664584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_technology ADD CONSTRAINT FK_67040D664235D463 FOREIGN KEY (technology_id) REFERENCES technologies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_application ADD CONSTRAINT FK_87443DE4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_application ADD CONSTRAINT FK_87443DE3E030ACD FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE technologies ADD CONSTRAINT FK_4CCBFB1812469DE2 FOREIGN KEY (category_id) REFERENCES technology_categories (id)');
        $this->addSql('ALTER TABLE technology_categories ADD CONSTRAINT FK_E74A135C727ACA70 FOREIGN KEY (parent_id) REFERENCES technology_categories (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_categories DROP FOREIGN KEY FK_4D707784727ACA70');
        $this->addSql('ALTER TABLE applications DROP FOREIGN KEY FK_F7C966F012469DE2');
        $this->addSql('ALTER TABLE product_categories DROP FOREIGN KEY FK_A9941943727ACA70');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE product_technology DROP FOREIGN KEY FK_67040D664584665A');
        $this->addSql('ALTER TABLE product_technology DROP FOREIGN KEY FK_67040D664235D463');
        $this->addSql('ALTER TABLE product_application DROP FOREIGN KEY FK_87443DE4584665A');
        $this->addSql('ALTER TABLE product_application DROP FOREIGN KEY FK_87443DE3E030ACD');
        $this->addSql('ALTER TABLE technologies DROP FOREIGN KEY FK_4CCBFB1812469DE2');
        $this->addSql('ALTER TABLE technology_categories DROP FOREIGN KEY FK_E74A135C727ACA70');
        $this->addSql('DROP TABLE application_categories');
        $this->addSql('DROP TABLE applications');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE memberships');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE pages');
        $this->addSql('DROP TABLE partners');
        $this->addSql('DROP TABLE product_categories');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE product_technology');
        $this->addSql('DROP TABLE product_application');
        $this->addSql('DROP TABLE technologies');
        $this->addSql('DROP TABLE technology_categories');
    }
}
