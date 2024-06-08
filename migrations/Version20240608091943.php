<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240608091943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_relation_second_products (product_source INT NOT NULL, product_target INT NOT NULL, INDEX IDX_AC99A2843DF63ED7 (product_source), INDEX IDX_AC99A28424136E58 (product_target), PRIMARY KEY(product_source, product_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_relation_second_products ADD CONSTRAINT FK_AC99A2843DF63ED7 FOREIGN KEY (product_source) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_relation_second_products ADD CONSTRAINT FK_AC99A28424136E58 FOREIGN KEY (product_target) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A9941943727ACA70 FOREIGN KEY (parent_id) REFERENCES product_categories (id)');
        $this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A99419434235D463 FOREIGN KEY (technology_id) REFERENCES technologies (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A4235D463 FOREIGN KEY (technology_id) REFERENCES technologies (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A12469DE2 FOREIGN KEY (category_id) REFERENCES product_categories (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product_product ADD CONSTRAINT FK_2931F1D3DF63ED7 FOREIGN KEY (product_source) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product ADD CONSTRAINT FK_2931F1D24136E58 FOREIGN KEY (product_target) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE settings DROP web_site, DROP customer_service');
        $this->addSql('ALTER TABLE technologies ADD CONSTRAINT FK_4CCBFB18727ACA70 FOREIGN KEY (parent_id) REFERENCES technologies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_relation_second_products DROP FOREIGN KEY FK_AC99A2843DF63ED7');
        $this->addSql('ALTER TABLE product_relation_second_products DROP FOREIGN KEY FK_AC99A28424136E58');
        $this->addSql('DROP TABLE product_relation_second_products');
        $this->addSql('ALTER TABLE product_categories DROP FOREIGN KEY FK_A9941943727ACA70');
        $this->addSql('ALTER TABLE product_categories DROP FOREIGN KEY FK_A99419434235D463');
        $this->addSql('ALTER TABLE product_product DROP FOREIGN KEY FK_2931F1D3DF63ED7');
        $this->addSql('ALTER TABLE product_product DROP FOREIGN KEY FK_2931F1D24136E58');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A4235D463');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A12469DE2');
        $this->addSql('ALTER TABLE settings ADD web_site VARCHAR(255) DEFAULT NULL, ADD customer_service VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE technologies DROP FOREIGN KEY FK_4CCBFB18727ACA70');
    }
}
