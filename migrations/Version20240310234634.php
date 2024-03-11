<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310234634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_technology (product_id INT NOT NULL, technology_id INT NOT NULL, INDEX IDX_67040D664584665A (product_id), INDEX IDX_67040D664235D463 (technology_id), PRIMARY KEY(product_id, technology_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_application (product_id INT NOT NULL, application_id INT NOT NULL, INDEX IDX_87443DE4584665A (product_id), INDEX IDX_87443DE3E030ACD (application_id), PRIMARY KEY(product_id, application_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_product_category (product_id INT NOT NULL, product_category_id INT NOT NULL, INDEX IDX_437017AA4584665A (product_id), INDEX IDX_437017AABE6903FD (product_category_id), PRIMARY KEY(product_id, product_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_technology ADD CONSTRAINT FK_67040D664584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_technology ADD CONSTRAINT FK_67040D664235D463 FOREIGN KEY (technology_id) REFERENCES technologies (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_application ADD CONSTRAINT FK_87443DE4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_application ADD CONSTRAINT FK_87443DE3E030ACD FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_category ADD CONSTRAINT FK_437017AA4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product_category ADD CONSTRAINT FK_437017AABE6903FD FOREIGN KEY (product_category_id) REFERENCES product_categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_technology DROP FOREIGN KEY FK_67040D664584665A');
        $this->addSql('ALTER TABLE product_technology DROP FOREIGN KEY FK_67040D664235D463');
        $this->addSql('ALTER TABLE product_application DROP FOREIGN KEY FK_87443DE4584665A');
        $this->addSql('ALTER TABLE product_application DROP FOREIGN KEY FK_87443DE3E030ACD');
        $this->addSql('ALTER TABLE product_product_category DROP FOREIGN KEY FK_437017AA4584665A');
        $this->addSql('ALTER TABLE product_product_category DROP FOREIGN KEY FK_437017AABE6903FD');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE product_technology');
        $this->addSql('DROP TABLE product_application');
        $this->addSql('DROP TABLE product_product_category');
    }
}
