<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422085927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_technology DROP FOREIGN KEY FK_67040D664235D463');
        $this->addSql('ALTER TABLE product_technology DROP FOREIGN KEY FK_67040D664584665A');
        $this->addSql('DROP TABLE product_technology');
        $this->addSql('ALTER TABLE products ADD technology_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A4235D463 FOREIGN KEY (technology_id) REFERENCES technologies (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A4235D463 ON products (technology_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_technology (product_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_67040D664235D463 (technology_id), INDEX IDX_67040D664584665A (product_id), PRIMARY KEY(product_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_technology ADD CONSTRAINT FK_67040D664235D463 FOREIGN KEY (technology_id) REFERENCES technologies (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_technology ADD CONSTRAINT FK_67040D664584665A FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A4235D463');
        $this->addSql('DROP INDEX IDX_B3BA5A5A4235D463 ON products');
        $this->addSql('ALTER TABLE products DROP technology_id');
    }
}
