<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240512205111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE settings ADD main_left_block_title VARCHAR(255) DEFAULT NULL, ADD main_left_block_summary VARCHAR(255) DEFAULT NULL, ADD main_left_block_image VARCHAR(255) DEFAULT NULL, ADD main_right_block_title VARCHAR(255) DEFAULT NULL, ADD main_right_block_summary VARCHAR(255) DEFAULT NULL, ADD main_right_block_images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE settings DROP main_left_block_title, DROP main_left_block_summary, DROP main_left_block_image, DROP main_right_block_title, DROP main_right_block_summary, DROP main_right_block_images');
    }
}
