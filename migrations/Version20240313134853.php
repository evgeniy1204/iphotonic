<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240313134853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products ADD images LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
		$this->addSql('ALTER TABLE applications ADD images LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
		$this->addSql('ALTER TABLE events ADD is_active TINYINT(1) DEFAULT 0 NOT NULL');
		$this->addSql('ALTER TABLE news ADD is_active TINYINT(1) DEFAULT 0 NOT NULL');
		$this->addSql('ALTER TABLE technologies ADD images LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP images');
		$this->addSql('ALTER TABLE news DROP is_active');
		$this->addSql('ALTER TABLE technologies DROP images');
		$this->addSql('ALTER TABLE events DROP is_active');
		$this->addSql('ALTER TABLE applications DROP images');
    }
}
