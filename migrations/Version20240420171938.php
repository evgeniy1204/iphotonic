<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240420171938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE applications DROP FOREIGN KEY FK_F7C966F012469DE2');
        $this->addSql('ALTER TABLE application_categories DROP FOREIGN KEY FK_4D707784727ACA70');
        $this->addSql('DROP TABLE application_categories');
        $this->addSql('DROP INDEX IDX_F7C966F012469DE2 ON applications');
        $this->addSql('ALTER TABLE applications DROP category_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application_categories (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_4D707784727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE application_categories ADD CONSTRAINT FK_4D707784727ACA70 FOREIGN KEY (parent_id) REFERENCES application_categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE applications ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE applications ADD CONSTRAINT FK_F7C966F012469DE2 FOREIGN KEY (category_id) REFERENCES application_categories (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F7C966F012469DE2 ON applications (category_id)');
    }
}
