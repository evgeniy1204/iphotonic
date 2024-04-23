<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240422155723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_product (product_source INT NOT NULL, product_target INT NOT NULL, INDEX IDX_2931F1D3DF63ED7 (product_source), INDEX IDX_2931F1D24136E58 (product_target), PRIMARY KEY(product_source, product_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_product ADD CONSTRAINT FK_2931F1D3DF63ED7 FOREIGN KEY (product_source) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product ADD CONSTRAINT FK_2931F1D24136E58 FOREIGN KEY (product_target) REFERENCES products (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_application DROP FOREIGN KEY FK_87443DE3E030ACD');
        $this->addSql('ALTER TABLE product_application DROP FOREIGN KEY FK_87443DE4584665A');
        $this->addSql('DROP TABLE product_application');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_application (product_id INT NOT NULL, application_id INT NOT NULL, INDEX IDX_87443DE3E030ACD (application_id), INDEX IDX_87443DE4584665A (product_id), PRIMARY KEY(product_id, application_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_application ADD CONSTRAINT FK_87443DE3E030ACD FOREIGN KEY (application_id) REFERENCES applications (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_application ADD CONSTRAINT FK_87443DE4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_product DROP FOREIGN KEY FK_2931F1D3DF63ED7');
        $this->addSql('ALTER TABLE product_product DROP FOREIGN KEY FK_2931F1D24136E58');
        $this->addSql('DROP TABLE product_product');
    }
}
