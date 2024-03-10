<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310140159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE applications (id INT AUTO_INCREMENT NOT NULL, text LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE application_application_category (application_id INT NOT NULL, application_category_id INT NOT NULL, INDEX IDX_599893203E030ACD (application_id), INDEX IDX_59989320BB8DB080 (application_category_id), PRIMARY KEY(application_id, application_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE application_application_category ADD CONSTRAINT FK_599893203E030ACD FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE application_application_category ADD CONSTRAINT FK_59989320BB8DB080 FOREIGN KEY (application_category_id) REFERENCES application_categories (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application_application_category DROP FOREIGN KEY FK_599893203E030ACD');
        $this->addSql('ALTER TABLE application_application_category DROP FOREIGN KEY FK_59989320BB8DB080');
        $this->addSql('DROP TABLE applications');
        $this->addSql('DROP TABLE application_application_category');
    }
}
